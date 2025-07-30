<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CagnoteScolaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nom',
        'description',
        'montant_objectif',
        'montant_collecte',
        'date_limite',
        'status',
    ];
}
