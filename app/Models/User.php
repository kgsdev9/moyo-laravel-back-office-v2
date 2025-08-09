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
        'contact_urgent',
        'fixe',
        'email',
        'avatar',
        'password',
        'codeSecret',
        'publicKey',
        'qrcode',
        'cvv',
        'numerocarte',
        'dateexpiration',
        'confirmated_at',
        'couleur_carte',
        'role',
        'statusCompte',
        'adresse',
        'piece_recto',
        'piece_verso',
        'status',
        'nomcomplet',
        'prenom',
        'ville_id',
        'commune_id',
        'specialite_id',
        'pays_id',
        'date_livraison',
        'payment',
        'description',
        'dernier_paiement_abonnement',
        'trimestres_impayes',
        'dernier_essai_prelevement',
    ];


    public function coffre()
    {
        return $this->hasOne(Coffre::class);
    }



    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }
    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
        'cvv',
        'numerocarte',
        'codeSecret',
        'publicKey',
    ];

    protected $casts = [
        'statusCompte' => 'boolean',
        'confirmated_at' => 'datetime',
        'dateexpiration' => 'date',
        'dernier_paiement_abonnement' => 'datetime',
    ];

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
