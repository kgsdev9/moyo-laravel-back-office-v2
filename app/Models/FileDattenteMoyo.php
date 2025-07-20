<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDattenteMoyo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'couleur_carte',
        'adresse',
        'ville_id',
        'commune_id',
        'pays_id',
        'date_livraison',
    ];

    protected $casts = [
        'date_livraison' => 'date',
    ];

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }
}
