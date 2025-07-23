<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    // Run the database seeds.
    public function run(): void
    {
        // Créer un admin
        if (!\App\Models\User::where('email', 'admin@example.com')->exists()) {
            \App\Models\User::create([
                'nom' => 'Admin',
                'prenom' => 'Super',
                'email' => 'admin@example.com',
                'mot_de_passe' => \Illuminate\Support\Facades\Hash::make('password'),
                'statut' => 'admin',
            ]);
        }

        // Créer un modérateur
        if (!\App\Models\User::where('email', 'moderateur@example.com')->exists()) {
            \App\Models\User::create([
                'nom' => 'Moderateur',
                'prenom' => 'Test',
                'email' => 'moderateur@example.com',
                'mot_de_passe' => \Illuminate\Support\Facades\Hash::make('password'),
                'statut' => 'moderateur',
            ]);
        }

        // Créer quelques clients
        if (!\App\Models\User::where('email', 'jean.dupont@example.com')->exists()) {
            \App\Models\User::create([
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'email' => 'jean.dupont@example.com',
                'mot_de_passe' => \Illuminate\Support\Facades\Hash::make('password'),
                'statut' => 'client',
            ]);
        }

        if (!\App\Models\User::where('email', 'marie.martin@example.com')->exists()) {
            \App\Models\User::create([
                'nom' => 'Martin',
                'prenom' => 'Marie',
                'email' => 'marie.martin@example.com',
                'mot_de_passe' => \Illuminate\Support\Facades\Hash::make('password'),
                'statut' => 'client',
            ]);
        }
    }
}
