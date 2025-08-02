<?php

namespace App\Services;

use App\Models\ModeReglement;

class ModeReglementService
{
    public function getAll()
    {
        return ModeReglement::orderBy('name')->get(); 
    }
}
