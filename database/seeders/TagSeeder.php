<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add some tags
        $tags = collect([
            'Neuf', 'Occasion', 'Promotion', 'Urgent', 'Électronique', 'Smartphone', 'Informatique', 'Console de jeux',
            'Maison', 'Jardin', 'Meubles', 'Décoration', 'Cuisine',
            'Véhicules', 'Voiture', 'Moto', 'Vélo', 'Pièces détachées',
            'Mode', 'Vêtements', 'Chaussures', 'Montres', 'Accessoires',
            'Loisirs', 'Jeux Vidéo', 'Films', 'Musique', 'Livres',
            'Sport', 'Fitness', 'Camping', 'Randonnée', 'Plein air',
            'Emploi', 'Freelance', 'Stage', 'CDI', 'CDD',
            'Éducation', 'Cours particuliers', 'Formation', 'Manuels scolaires', 'Langues',
            'Voyages', 'Billets', 'Hôtel', 'Location saisonnière',
            'Services', 'Déménagement', 'Réparation', 'Ménage', 'Coaching',
            'Animaux', 'Chien', 'Chat', 'Oiseaux', 'Reptiles',
            'Matériel Professionnel', 'BTP', 'Industrie', 'Commerce', 'Médical',
            'Troc & Échanges', 'Don', 'Échange', 'Gratuit',
            'Autre'
        ]);

        $tags->each(fn ($tag) => Tag::create([
            'name' => $tag
        ]));
    }
}
