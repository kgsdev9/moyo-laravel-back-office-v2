<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coffre extends Model
{
    use HasFactory;

    protected $fillable = [
        'solde',
        'user_id',
        'date_expiration',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
