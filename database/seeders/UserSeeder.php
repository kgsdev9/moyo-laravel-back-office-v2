<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'codemembre' => 'CDCI001',
                'phone' => '0101010101',
                'qrcode' => Str::uuid(),
                'email' => 'admin@cdeici.ci',
                'nom' => 'Kouassi',
                'prenom' => 'Jean',
                'piece_avant' => 'piece_avant_001.jpg',
                'piece_arriere' => 'piece_arriere_001.jpg',
                'pin' => Hash::make('123456'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'membre1',
                'codemembre' => 'CDCI002',
                'phone' => '0202020202',
                'qrcode' => Str::uuid(),
                'email' => 'membre1@cdeici.ci',
                'nom' => 'Koné',
                'prenom' => 'Fatou',
                'piece_avant' => 'piece_avant_002.jpg',
                'piece_arriere' => 'piece_arriere_002.jpg',
               'pin' => Hash::make('123321'),
                'active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
