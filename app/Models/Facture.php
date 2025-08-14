<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'codefacture',
        'commande_id',
        'user_id',
        'adresse',
        'montantlivraison',
        'date_echeance',
        'remise',
        'status',
        'montantht',
        'montantttc',
        'montanttva',
        'montantregle',
        'montantrestant'
    ];
}
