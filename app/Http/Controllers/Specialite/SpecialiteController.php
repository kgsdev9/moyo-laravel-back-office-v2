<?php

namespace App\Http\Controllers\Specialite;

use App\Http\Controllers\Controller;
use App\Services\SpecialiteService;

class SpecialiteController extends Controller
{
    protected $service;

    public function __construct(SpecialiteService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $specialites = $this->service->getAll();

        return response()->json([
            'success' => true,
            'data' => $specialites
        ]);
    }
}
