<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'modereglementname',
        'reference',
        'montant',
        'solderestant',
        'fraisoperateur',
        'fraisservice',
        'modereglement_id',
        'ecole_id',
        'entreprise_id',
        'typeoperation',
        'status',
        'observation',
        'description',
        'user_id',
        'sender_id',
        'recepteur_id',
        'telephone'
    ];

    public function modeReglement()
    {
        return $this->belongsTo(ModeReglement::class, 'modereglement_id');
    }

    public function ecole()
    {
        return $this->belongsTo(Ecole::class, 'ecole_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recepteur()
    {
        return $this->belongsTo(User::class, 'recepteur_id');
    }
}
