<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'telephone',
        'password',
        'codeSecret',
        'publicKey',
        'role',
        'statusCompte',
    ];

    protected $hidden = [
        'password',
        'codeSecret',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // // Relations
    // public function client()
    // {
    //     return $this->hasOne(Client::class);
    // }

    // public function entreprise()
    // {
    //     return $this->hasOne(Entreprise::class);
    // }

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
