<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EcoleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EcoleController extends Controller
{
    protected $ecoleService;

    public function __construct(EcoleService $ecoleService)
    {
        $this->ecoleService = $ecoleService;
    }

    public function index(Request $request): JsonResponse
    {
        $ecoles = $this->ecoleService->getEcoles($request);

        return response()->json($ecoles);
    }
}
