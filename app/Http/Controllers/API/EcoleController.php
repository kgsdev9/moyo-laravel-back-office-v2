<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EcoleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Ecole::with('category');

        if ($request->has('category_school_id'))
        {
            $query->where('category_school_id', $request->category_school_id);
        }

        $ecoles = $query->where('active', true)->paginate(40);
        return response()->json($ecoles);
    }
}

