<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CagnoteSouscriveur extends Model
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
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeEnCours($query)
    {
        return $query->where('status', 'encours');
    }
    public function scopeCloture($query)
    {
        return $query->where('status', 'cloture');
    }
}
