<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CategorySchoolService;
use Illuminate\Http\JsonResponse;

class CategorySchoolController extends Controller
{
    protected CategorySchoolService $categorySchoolService;

    public function __construct(CategorySchoolService $categorySchoolService)
    {
        $this->categorySchoolService = $categorySchoolService;
    }

    public function index(): JsonResponse
    {
        $categories = $this->categorySchoolService->getAll();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
}
