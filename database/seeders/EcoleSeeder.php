<?php

namespace Database\Seeders;

use App\Models\Ecole;
use App\Models\CategorySchool;
use Illuminate\Database\Seeder;

class EcoleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = CategorySchool::all();

        $batch = [];

        for ($i = 1; $i <= 10000; $i++) {
            $category = $categories->random();

            $batch[] = [
                'nom' => 'École #' . $i,
                'email' => "ecole{$i}@example.com",
                'siteweb' => "https://ecole{$i}.ci",
                'logo' => "https://ui-avatars.com/api/?name=E{$i}&background=37715d&color=fff",
                'image' => "https://source.unsplash.com/640x480/?school&sig={$i}",
                'active' => rand(0, 1),
                'category_school_id' => $category->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($batch, 1000) as $chunk) {
            Ecole::insert($chunk);
        }
    }
}
