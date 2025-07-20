<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecole extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'sigle',
        'code',
        'email',
        'adresse',
        'siteweb',
        'rib',
        'telephone',
        'fixe',
        'logo',
        'num_rccm',
        'active',
        'user_id',
        'category_school_id',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(CategorySchool::class);
    }
}
