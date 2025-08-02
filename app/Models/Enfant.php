<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'matricule',
        'email',
        'user_id',
        'ecole_id',
        'ville_id',
        'classe_id',
        'pays_id',
    ];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }
}
