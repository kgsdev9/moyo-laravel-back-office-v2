<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epargne extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'solde',
        'datebutoire',
    ];

    protected $casts = [
        'solde' => 'decimal:2',
        'datebutoire' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estEcheanceAtteinte(): bool
    {
        return $this->datebutoire->isPast();
    }
}
