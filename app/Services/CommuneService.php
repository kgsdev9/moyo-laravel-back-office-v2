<?php

namespace App\Services;

use App\Models\Commune;

class CommuneService
{
    /**
     * Récupérer toutes les communes
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Commune::orderBy('name')->get(); 
    }
}
