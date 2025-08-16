<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'codecommande',
        'qtecmde',
        'montantht',
        'user_id',
        'adresse',
        'commune_id',
        'montantlivraison',
        'datelivraison',
        'date_echeance',
        'remise',
        'status',
        'montantttc',
        'montanttva',
        'montantregle',
        'montantrestant'
    ];

    //montantaregleralalivraison
}
