<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = [
            [
                'category_id' => 1,
                'libelle' => 'Cahier 100 pages',
                'quantite' => '50',
                'description' => 'Cahier à carreaux 100 pages, parfait pour l’école.',
                'pu' => 500.00,
                'disponibilite' => true,
            ],
            [
                'category_id' => 1,
                'libelle' => 'Stylo bille bleu',
                'quantite' => '100',
                'description' => 'Stylo bille à encre bleue.',
                'pu' => 150.00,
                'disponibilite' => true,
            ],
            [
                'category_id' => 1,
                'libelle' => 'Crayon à papier HB',
                'quantite' => '200',
                'description' => 'Crayon à papier HB de qualité standard.',
                'pu' => 100.00,
                'disponibilite' => true,
            ],
            [
                'category_id' => 1,
                'libelle' => 'Gomme blanche',
                'quantite' => '150',
                'description' => 'Gomme douce pour effacer le crayon sans abîmer le papier.',
                'pu' => 75.00,
                'disponibilite' => true,
            ],
            [
                'code' => 'ART005',
                'category_id' => 1,
                'libelle' => 'Règle 30 cm',
                'quantite' => '80',
                'description' => 'Règle transparente de 30 cm.',
                'pu' => 120.00,
                'disponibilite' => true,
            ],
            [
                'code' => 'ART006',
              'category_id' => 1,
                'libelle' => 'Trousse scolaire',
                'quantite' => '60',
                'description' => 'Trousse pour ranger stylos, crayons et autres fournitures.',
                'pu' => 1000.00,
                'disponibilite' => true,
            ],
            [
                'code' => 'ART007',
                'category_id' => 1,
                'libelle' => 'Cahier 200 pages',
                'quantite' => '40',
                'description' => 'Cahier à carreaux, idéal pour les cours intensifs.',
                'pu' => 900.00,
                'disponibilite' => true,
            ],
            [
                'code' => 'ART008',
                 'category_id' => 1,
                'libelle' => 'Stylo plume',
                'quantite' => '30',
                'description' => 'Stylo plume avec cartouche bleue.',
                'pu' => 1200.00,
                'disponibilite' => true,
            ],
            [
                'code' => 'ART009',
                'category_id' => 1,
                'libelle' => 'Feutres de couleurs',
                'quantite' => '50',
                'description' => 'Set de 12 feutres colorés.',
                'pu' => 800.00,
                'disponibilite' => true,
            ],
            [
                'code' => 'ART010',
               'category_id' => 1,
                'libelle' => 'Compas',
                'quantite' => '40',
                'description' => 'Compas pour tracer des cercles précis.',
                'pu' => 400.00,
                'disponibilite' => true,
            ],
            [
                'code' => 'ART011',
                'category_id' => 1,
                'libelle' => 'Bloc-notes',
                'quantite' => '70',
                'description' => 'Petit bloc-notes pour les cours.',
                'pu' => 300.00,
                'disponibilite' => true,
            ],
            [
                'category_id' => 1,
                'libelle' => 'Cahier de maths',
                'quantite' => '60',
                'description' => 'Cahier à carreaux pour les exercices de mathématiques.',
                'pu' => 550.00,
                'disponibilite' => true,
            ],
            [
                'category_id' => 1,
                'libelle' => 'Crayons de couleur',
                'quantite' => '80',
                'description' => 'Boîte de 12 crayons de couleur.',
                'pu' => 600.00,
                'disponibilite' => true,
            ],
            [

                'category_id' => 1,
                'libelle' => 'Équerre 45°',
                'quantite' => '35',
                'description' => 'Équerre pour tracer des angles précis.',
                'pu' => 250.00,
                'disponibilite' => true,
            ],
            [
               'category_id' => 1,
                'libelle' => 'Ciseaux',
                'quantite' => '50',
                'description' => 'Ciseaux avec poignée ergonomique.',
                'pu' => 350.00,
                'disponibilite' => true,
            ],
            [
                 'category_id' => 1,
                'libelle' => 'Cahier de français',
                'quantite' => '55',
                'description' => 'Cahier à lignes pour les cours de français.',
                'pu' => 500.00,
                'disponibilite' => true,
            ],
            [
                'category_id' => 1,
                'libelle' => 'Marqueurs permanents',
                'quantite' => '40',
                'description' => 'Marqueurs noirs et rouges.',
                'pu' => 450.00,
                'disponibilite' => true,
            ],
            [
                 'category_id' => 1,
                'libelle' => 'Calculatrice scientifique',
                'quantite' => '25',
                'description' => 'Calculatrice pour les lycéens et étudiants.',
                'pu' => 5000.00,
                'disponibilite' => true,
            ],
            [
                'category_id' => 1,
                'libelle' => 'Agenda scolaire',
                'quantite' => '60',
                'description' => 'Agenda pour organiser ses devoirs et cours.',
                'pu' => 1200.00,
                'disponibilite' => true,
            ],
            [
               'category_id' => 1,
                'libelle' => 'Surligneurs',
                'quantite' => '100',
                'description' => 'Lot de 5 surligneurs de couleurs différentes.',
                'pu' => 700.00,
                'disponibilite' => true,
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
