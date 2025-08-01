<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationCodeMail;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $user = User::create([
            'name'        => $request->name,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'pin'         => bcrypt($request->pin),
            'codemembre'  => User::generateCodeMembre(),
            'qrcode'      => User::generateQrCode(),
        ]);
        $token = $user->createToken('mobile_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $request->input('phone');

        // Vérifie si l'utilisateur existe déjà
        $user = User::where('telephone', $phone)->first();

        if ($user) {

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'phone' => $user->telephone,
                    'role' => $user->role,
                ]
            ], 200);
        }

        // Génère un code aléatoire
        $code = strval(random_int(1000, 9999));
        $expiresAt = now()->addMinutes(5);

        // Stocke dans le cache temporairement
        Cache::put("code_{$phone}", [
            'code' => $code,
            'expires_at' => $expiresAt,
        ], now()->addMinutes(5));

        $email ='kgsdev8@gmail.com';
        Mail::to($email)->send(new SendVerificationCodeMail($code));
        
        return response()->json([
            'message' => 'Code envoyé par e-mail',
            'code' => $code
        ], 200);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string',
        ]);

        $phone = $request->input('phone');
        $code = $request->input('code');

        // Récupérer le code depuis le cache
        $record = Cache::get("code_{$phone}");

        if (!$record) {
            return response()->json(['error' => 'Aucun code trouvé pour ce numéro'], 401);
        }

        if ($record['code'] !== $code) {
            return response()->json(['error' => 'Code invalide'], 401);
        }

        if (now()->greaterThan($record['expires_at'])) {
            return response()->json(['error' => 'Code expiré'], 401);
        }

        // Supprimer le code une fois utilisé
        Cache::forget("code_{$phone}");

        // Vérifier ou créer l'utilisateur
        $user = User::where('telephone', $phone)->first();

        if (!$user) {
            $user = User::create([
                'telephone' => $phone,
                'role' => 'client', // ou autre valeur par défaut
                'qrcode' => User::generateQrCode(),
            ]);
        }

        // Ici, **ne pas générer ni renvoyer de token**
        return response()->json([
            // 'token' => $token, // supprimé
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('telephone', $request->phone)->first();
        if (! $user || ! \Hash::check($request->pin, $user->codeSecret)) {
            return response()->json(['message' => 'Erreurs sur les informations de connexions'], 401);
        }

        $token = $user->createToken('mobile_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
            'phone' => $request->phone
        ]);
    }

    public function setSecret(Request $request)
    {
        try {
            $user = User::where('id', $request->userId)->first();
            if (!$user) {
                return response()->json(['error' => 'Utilisateur non trouvé'], 404);
            }

            $hashedCode = Hash::make($request->pin);

            $user->update([
                'codeSecret' => $hashedCode,
                'password' => $hashedCode,
            ]);

            // Générer le token Sanctum après mise à jour du secret
            $token = $user->createToken('mobile_token')->plainTextToken;

            return response()->json([
                'message' => 'Profil enregistré avec succès.',
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur serveur',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }



    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
