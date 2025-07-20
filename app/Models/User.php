<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'telephone',
        'email',
        'avatar',
        'password',
        'codeSecret',
        'publicKey',
        'qrcode',
        'confirmated_at',
        'role',
        'statusCompte',
    ];

    protected $casts = [
        'confirmated_at' => 'date',
        'statusCompte' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'codeSecret',
    ];

    // Relations
    public function profil()
    {
        return $this->hasOne(Profil::class);
    }

    public function entreprise()
    {
        return $this->hasOne(Entreprise::class);
    }

    public function ecole()
    {
        return $this->hasOne(Ecole::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public static function generateQrCode(): string
    {
        return Str::uuid();
    }
}
