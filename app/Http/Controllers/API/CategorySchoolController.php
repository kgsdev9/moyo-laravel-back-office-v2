<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CategorySchool;
use Illuminate\Http\JsonResponse;

class CategorySchoolController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(CategorySchool::all());
    }
}
