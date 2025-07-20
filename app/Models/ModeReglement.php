<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeReglement extends Model
{
    use HasFactory;
        protected $fillable = [
        'name',
        'image',
        'taux_frais',
        'active',
        'typemoderegleemnt',
    ];

    protected $casts = [
        'taux_frais' => 'decimal:2',
        'active' => 'boolean',
    ];
}
