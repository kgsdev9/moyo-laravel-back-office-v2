<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategorySchool;

class CategorySchoolSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Grande École', 'Collège', 'Lycée', 'Université'];

        foreach ($categories as $name) {
            CategorySchool::create(['name' => $name]);
        }
    }
}
