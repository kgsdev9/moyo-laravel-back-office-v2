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
        'fraisoperateur',
        'fraisservice',
        'modereglement_id',
        'ecole_id',
        'entreprise_id',
        'typeoperation',
        'status',
        'observation',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modereglement()
    {
        return $this->belongsTo(ModeReglement::class);
    }
}
