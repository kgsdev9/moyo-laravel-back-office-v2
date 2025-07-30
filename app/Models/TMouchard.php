<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TMouchard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'module',
        'val_ancienne',
        'val_nouvelle',
        'ip',
        'navigateur',  
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
