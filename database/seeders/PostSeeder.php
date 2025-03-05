<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'user_id' => 1,
                'title' => 'Maison à vendre',
                'slug' => 'maison-a-vendre',
                'description' => 'Belle maison avec jardin et piscine.',
                'category_id' => 1,
                'price' => 250000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'published_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Voiture d’occasion',
                'slug' => 'voiture-d-occasion',
                'description' => 'Voiture en bon état, faible kilométrage.',
                'category_id' => 2,
                'price' => 12000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'published_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Laptop Gamer',
                'slug' => 'laptop-gamer',
                'description' => 'PC Gamer RTX 3060, parfait pour le gaming et le travail.',
                'category_id' => 3,
                'price' => 1500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'published_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Smartphone Neuf',
                'slug' => 'smartphone-neuf',
                'description' => 'iPhone 14 Pro, neuf avec facture et garantie.',
                'category_id' => 4,
                'price' => 1100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'published_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'title' => 'Vélo tout terrain',
                'slug' => 'velo-tout-terrain',
                'description' => 'VTT en excellent état, utilisé seulement quelques fois.',
                'category_id' => 5,
                'price' => 300,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'published_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'title' => 'Cours de guitare',
                'slug' => 'cours-de-guitare',
                'description' => 'Professeur expérimenté donne cours de guitare à domicile.',
                'category_id' => 6,
                'price' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'published_at' => Carbon::now(),
            ]
        ]);
    }
}
