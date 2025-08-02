<?php

namespace App\Services;

use App\Mail\SendVerificationCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function sendVerificationCode(string $phone): array
    {
        $code = strval(random_int(1000, 9999));
        $expiresAt = now()->addMinutes(5);

        Cache::put("code_{$phone}", [
            'code' => $code,
            'expires_at' => $expiresAt,
        ], $expiresAt);

        Mail::to(config('auth.admin_email'))->send(new SendVerificationCodeMail($code));

        return [
            'code' => $code,
            'expires_at' => $expiresAt
        ];
    }

    public function verifyCode(string $phone, string $code): ?User
    {
        $record = Cache::get("code_{$phone}");

        if (!$record || $record['code'] !== $code || now()->greaterThan($record['expires_at'])) {
            return null;
        }

        Cache::forget("code_{$phone}");

        return $this->findOrCreateUserByPhone($phone);
    }

    protected function findOrCreateUserByPhone(string $phone): User
    {
        $user = User::firstOrCreate(
            ['telephone' => $phone],
            [
                'role' => 'client',
                'qrcode' => User::generateQrCode()
            ]
        );

        // Créer le coffre si nécessaire
        if (!$user->coffre) {
            $user->coffre()->create([
                'solde' => 0,
                'date_expiration' => now()->addYear(),
            ]);
        }

        return $user;
    }

    public function login(string $phone, string $pin): ?User
    {
        $user = User::where('telephone', $phone)->first();

        if ($user && Hash::check($pin, $user->codeSecret)) {
            return $user;
        }

        return null;
    }

    public function setSecret(int $userId, string $pin): ?User
    {
        $user = User::find($userId);
        if (!$user) return null;

        $hashed = Hash::make($pin);

        $user->update([
            'codeSecret' => $hashed,
            'password'   => $hashed,
        ]);

        return $user;
    }
}
