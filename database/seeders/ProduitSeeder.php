<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    // Run the database seeds.
    public function run(): void
    {
        // Créer les produits basés sur vos données SQLite
        Produit::create([
            'nom' => 'Croquettes Premium Chat',
            'prix' => 12.99, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Croquettes de haute qualité pour chat adulte, riches en protéines et vitamines.',
            'image_path' => 'produits/croquettes-chat.jpg',
            'categorie' => 'Chat',
        ]);

        Produit::create([
            'nom' => 'Jouet Souris Interactive',
            'prix' => 7.49, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Jouet interactif pour chat avec capteur de mouvement et sons réalistes.',
            'image_path' => 'produits/jouet-souris.jpg',
            'categorie' => 'Chat',
        ]);

        Produit::create([
            'nom' => 'Arbre à Chat Deluxe',
            'prix' => 89.99, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Arbre à chat multi-niveaux avec griffoir et niches de repos.',
            'image_path' => 'produits/arbre-chat.jpg',
            'categorie' => 'Chat',
        ]);

        Produit::create([
            'nom' => 'Litière Écologique',
            'prix' => 15.49, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Litière 100% naturelle et biodégradable, sans poussière.',
            'image_path' => 'produits/litiere-eco.jpg',
            'categorie' => 'Chat',
        ]);

        // Créer quelques produits de test pour Chien  
        Produit::create([
            'nom' => 'Croquettes Premium Chien',
            'prix' => 18.99, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Croquettes de haute qualité pour chien adulte, riches en protéines et vitamines.',
            'image_path' => 'produits/croquettes-chien.jpg',
            'categorie' => 'Chien',
        ]);

        Produit::create([
            'nom' => 'Laisse Rétractable',
            'prix' => 24.99, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Laisse rétractable 5m avec poignée ergonomique et système de freinage.',
            'image_path' => 'produits/laisse-retractable.jpg',
            'categorie' => 'Chien',
        ]);

        Produit::create([
            'nom' => 'Jouet Balle Tennis',
            'prix' => 9.99, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Set de 3 balles de tennis spécialement conçues pour les chiens.',
            'image_path' => 'produits/balle-tennis.jpg',
            'categorie' => 'Chien',
        ]);

        Produit::create([
            'nom' => 'Transport Souple',
            'prix' => 29.99, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Sac de transport confortable et sécurisé pour chat et petit chien.',
            'image_path' => 'produits/transport-souple.jpg',
            'categorie' => 'Chien',
        ]);
    }
}
