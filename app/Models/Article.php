<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantite',
        'category_id',
        'libelle',
        'description',
        'pu',
        'librairy_id',
        'disponibilite'
    ];
}
