<?php

namespace App\Http\Controllers\Commune;

use App\Http\Controllers\Controller;
use App\Services\CommuneService;

class CommuneController extends Controller
{
    protected CommuneService $communeService;

    public function __construct(CommuneService $communeService)
    {
        $this->communeService = $communeService;
    }

    public function index()
    {
        $communes = $this->communeService->getAll();

        return response()->json([
            'success' => true,
            'communes' => $communes,
        ]);
    }
}
