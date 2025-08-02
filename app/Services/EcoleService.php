<?php

namespace App\Services;

use App\Models\Ecole;
use Illuminate\Http\Request;

class EcoleService
{
    public function getEcoles(Request $request, int $perPage = 40)
    {
        $query = Ecole::with('category')
            ->where('active', true);

        if ($request->has('category_school_id')) {
            $query->where('category_school_id', $request->input('category_school_id'));
        }

        return $query->paginate($perPage);
    }
}
