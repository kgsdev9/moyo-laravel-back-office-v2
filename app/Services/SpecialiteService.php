<?php

namespace App\Services;

use App\Models\Specialite;

class SpecialiteService
{
    public function getAll()
    {
        return Specialite::orderBy('name')->get();
    }
}
