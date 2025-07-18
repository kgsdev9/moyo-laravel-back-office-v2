<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecole extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'siteweb',
        'logo',
        'image',
        'active',
        'category_school_id',
    ];

    public function category()
    {
        return $this->belongsTo(CategorySchool::class);
    }
}
