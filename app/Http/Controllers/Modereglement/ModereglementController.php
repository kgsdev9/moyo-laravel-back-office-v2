<?php

namespace App\Http\Controllers\Modereglement;

use App\Http\Controllers\Controller;
use App\Services\ModeReglementService;

class ModereglementController extends Controller
{
    protected ModeReglementService $service;

    public function __construct(ModeReglementService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $modereglements = $this->service->getAll();

        return response()->json([
            'success' => true,
            'data' => $modereglements,
        ]);
    }
}
