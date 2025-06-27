<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'codemembre',
        'phone',
        'qrcode',
        'email',
        'nom',
        'prenom',
        'piece_avant',
        'piece_arriere',
        'pin',
        'active',
    ];

    protected $hidden = ['pin', 'remember_token'];

    public static function generateCodeMembre(): string
    {
        $year = now()->year;
        $prefix = "MOYO-{$year}-";

        $lastCode = DB::table('users')
            ->where('codemembre', 'like', $prefix . '%')
            ->orderByDesc('codemembre')
            ->value('codemembre');

        if ($lastCode) {
            $lastNumber = (int)substr($lastCode, -6);
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        return $prefix . $newNumber;
    }

    public static function generateQrCode(): string
    {
        return Str::uuid(); 
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
