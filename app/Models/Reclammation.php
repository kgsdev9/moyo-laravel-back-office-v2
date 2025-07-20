<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclammation extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'objet',
    'reference',
    'message',
    'date_rdv',
    'heure_rdv',
    'canal',
    'statut',
];

}
