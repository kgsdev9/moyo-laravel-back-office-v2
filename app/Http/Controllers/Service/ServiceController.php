<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Services\ServiceUserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    protected ServiceUserService $service;

    public function __construct(ServiceUserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['specialite_id']);
        $users = $this->service->getUsers($filters);

        return response()->json($users);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->service->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        return response()->json(['user' => $user]);
    }
}
