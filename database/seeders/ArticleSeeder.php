<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    // Run the database seeds.
    public function run(): void
    {
        // Récupérer un utilisateur admin pour les articles
        $admin = User::where('statut', 'admin')->first();
        
        if (!$admin) {
            // Si pas d'admin, créer un utilisateur de base
            $admin = User::first();
        }

        // Créer quelques articles de test
        Article::create([
            'titre' => 'Les 10 règles d\'or pour bien nourrir votre chat',
            'description' => 'Découvrez les secrets d\'une alimentation équilibrée pour votre félin.',
            'contenu' => 'Une alimentation équilibrée est essentielle pour la santé de votre chat...',
            'image' => 'articles/nutrition-chat.jpg',
            'banniere_article' => 'articles/bannieres/nutrition-chat-banner.jpg',
            'date_publication' => now(),
            'id_utilisateur' => $admin->id,
            'categorie' => 'Chat',
        ]);

        Article::create([
            'titre' => 'Comment dresser votre chiot en 5 étapes simples',
            'description' => 'Guide pratique pour éduquer votre chiot avec bienveillance.',
            'contenu' => 'L\'éducation d\'un chiot demande patience et constance...',
            'image' => 'articles/dressage-chiot.jpg',
            'banniere_article' => 'articles/bannieres/dressage-chiot-banner.jpg',
            'date_publication' => now()->subDays(2),
            'id_utilisateur' => $admin->id,
            'categorie' => 'Chien',
        ]);

        Article::create([
            'titre' => 'Préparer l\'arrivée d\'un chat à la maison',
            'description' => 'Tous les conseils pour accueillir votre nouveau compagnon félin.',
            'contenu' => 'L\'arrivée d\'un chat dans une nouvelle maison nécessite une préparation...',
            'image' => 'articles/accueil-chat.jpg',
            'banniere_article' => 'articles/bannieres/accueil-chat-banner.jpg',
            'date_publication' => now()->subWeek(),
            'id_utilisateur' => $admin->id,
            'categorie' => 'Chat',
        ]);

        Article::create([
            'titre' => 'Les races de chiens adaptées aux familles',
            'description' => 'Choisir la bonne race de chien selon votre style de vie familial.',
            'contenu' => 'Certaines races de chiens sont particulièrement adaptées à la vie en famille...',
            'image' => 'articles/races-chiens-famille.jpg',
            'banniere_article' => 'articles/bannieres/races-chiens-famille-banner.jpg',
            'date_publication' => now()->subWeeks(2),
            'id_utilisateur' => $admin->id,
            'categorie' => 'Chien',
        ]);
    }
}
