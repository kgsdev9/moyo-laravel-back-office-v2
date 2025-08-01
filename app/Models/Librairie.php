<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librairie extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nom',
        'email',
        'adresse',
        'ville_id',
        'commune_id',
        'pays_id',
        'active',
        'nrcccm'
    ];
}
