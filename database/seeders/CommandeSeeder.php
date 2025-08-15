<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commande;
use Faker\Factory as Faker;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            $montantttc = $faker->numberBetween(10000, 50000);
            $montantregle = $faker->numberBetween(0, $montantttc);

            Commande::create([
                'qtecmde' => $faker->numberBetween(1, 5),
                'montantht' => $montantttc - ($montantttc * 0.18), // HT = TTC - TVA 18%
                'user_id' => 36,
                'commune_id' => 1,
                'adresse' => $faker->address,
                'montantlivraison' => $faker->numberBetween(1000, 5000),
                'datelivraison' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'date_echeance' => $faker->dateTimeBetween('now', '+2 months'),
                'remise' => $faker->numberBetween(0, 5000),
                // 'status' => $montantregle >= $montantttc ? 'solde' : 'nonsolde',
                'montantttc' => $montantttc,
                'montanttva' => $montantttc * 0.18,
                'montantregle' => $montantregle,
                'montantrestant' => $montantttc - $montantregle,
            ]);
        }
    }
}
