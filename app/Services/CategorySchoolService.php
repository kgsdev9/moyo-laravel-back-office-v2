<?php

namespace App\Services;

use App\Models\CategorySchool;

class CategorySchoolService
{
    public function getAll()
    {
        return CategorySchool::orderBy('name')->get();
    }
}
