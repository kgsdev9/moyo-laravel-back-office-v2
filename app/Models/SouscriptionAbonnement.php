<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SouscriptionAbonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'abonnement_id',
        'date_debut',
        'date_fin',
        'actif',
        'prix',
    ];
}
