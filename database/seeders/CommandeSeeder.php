<?php

namespace Database\Seeders;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommandeSeeder extends Seeder
{
    // Exécuter le seeding de commandes de test.
    public function run(): void
    {
        // S'assurer que nous avons des utilisateurs et des produits
        $utilisateurs = User::all();
        $produits = Produit::all();
        
        if ($utilisateurs->isEmpty() || $produits->isEmpty()) {
            $this->command->info('Aucun utilisateur ou produit trouvé. Impossible de créer des commandes.');
            return;
        }
        
        // Créer quelques commandes
        for ($i = 0; $i < 5; $i++) {
            $utilisateur = $utilisateurs->random();
            
            $commande = Commande::create([
                'id_utilisateur' => $utilisateur->id,
                'date_commande' => Carbon::now()->subDays(rand(1, 30)),
            ]);
            
            // Ajouter 1 à 3 produits aléatoires à chaque commande
            $produitsCommande = $produits->random(rand(1, 3));
            
            foreach ($produitsCommande as $produit) {
                $commande->produits()->attach($produit->id, [
                    'quantite' => rand(1, 5),
                    'prix_unitaire' => $produit->prix, // Prix en centimes au moment de la commande
                ]);
            }
        }
        
        $this->command->info('5 commandes créées avec succès.');
    }
}
