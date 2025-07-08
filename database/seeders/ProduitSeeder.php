<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    // Run the database seeds.
    public function run(): void
    {
        // Créer quelques produits de test
        Produit::create([
            'nom' => 'Croquettes Premium Chat',
            'prix' => 12.99, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Croquettes de haute qualité pour chat adulte, riches en protéines et vitamines.',
            'image' => 'produits/croquettes-chat.jpg',
        ]);

        Produit::create([
            'nom' => 'Jouet Souris Interactive',
            'prix' => 7.49, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Jouet interactif pour chat avec capteur de mouvement et sons réalistes.',
            'image' => 'produits/jouet-souris.jpg',
        ]);

        Produit::create([
            'nom' => 'Arbre à Chat Deluxe',
            'prix' => 89.99, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Arbre à chat multi-niveaux avec griffoir et niches de repos.',
            'image' => 'produits/arbre-chat.jpg',
        ]);

        Produit::create([
            'nom' => 'Litière Écologique',
            'prix' => 15.49, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Litière 100% naturelle et biodégradable, sans poussière.',
            'image' => 'produits/litiere-eco.jpg',
        ]);

        Produit::create([
            'nom' => 'Transport Souple',
            'prix' => 29.99, // Prix en euros (sera converti en centimes par le mutateur)
            'description' => 'Sac de transport confortable et sécurisé pour chat et petit chien.',
            'image' => 'produits/transport-souple.jpg',
        ]);
    }
}
