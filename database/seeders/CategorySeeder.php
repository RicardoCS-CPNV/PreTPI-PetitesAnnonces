<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert data into the 'categories' table
        DB::table('categories')->insert([
            ['name' => 'Immobilier', 'description' => 'Annonces de vente et location d’appartements, maisons, terrains, bureaux.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Véhicules', 'description' => 'Achat et vente de voitures, motos, vélos, camions, camping-cars et pièces détachées.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Emploi & Services', 'description' => 'Offres d’emploi, recherches de candidats, services professionnels, freelances.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Électronique & High-Tech', 'description' => 'Vente de smartphones, ordinateurs, consoles, tablettes, accessoires tech.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Mode & Accessoires', 'description' => 'Vêtements, chaussures, sacs, montres, bijoux, lunettes et accessoires de mode.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Maison & Jardin', 'description' => 'Meubles, décoration, électroménager, jardinage, bricolage, ustensiles de cuisine.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Loisirs & Sports', 'description' => 'Articles de sport, équipements de fitness, instruments de musique, jeux vidéo, DVD.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Animaux', 'description' => 'Annonces de vente et adoption d’animaux (chiens, chats, oiseaux, reptiles), accessoires.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Éducation & Cours', 'description' => 'Cours particuliers, formations en ligne, manuels scolaires, annonces de soutien scolaire.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Événements', 'description' => 'Billets de concert, événements culturels, festivals, soirées, séminaires et conférences.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Matériel Professionnel', 'description' => 'Vente d’outils et d’équipements pour professionnels (bâtiment, agriculture, médical).', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Voyages & Vacances', 'description' => 'Locations saisonnières, hôtels, billets d’avion, voyages organisés, covoiturage.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Services Divers', 'description' => 'Petites annonces pour services divers (ménage, déménagement, dépannage informatique).', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Troc & Échanges', 'description' => 'Annonces pour échange d’objets, troc de biens, dons gratuits.', 'created_at' => Now(), 'updated_at' => Now()],
            ['name' => 'Autre', 'description' => 'Pour toutes les annonces qui ne rentrent pas dans les catégories existantes.', 'created_at' => Now(), 'updated_at' => Now()],
        ]);
    }
}
