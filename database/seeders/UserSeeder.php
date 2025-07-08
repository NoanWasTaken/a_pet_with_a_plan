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
        \App\Models\User::create([
            'nom' => 'Admin',
            'prenom' => 'Super',
            'email' => 'admin@example.com',
            'mot_de_passe' => \Illuminate\Support\Facades\Hash::make('password'),
            'statut' => 'admin',
        ]);

        // Créer un modérateur
        \App\Models\User::create([
            'nom' => 'Moderateur',
            'prenom' => 'Test',
            'email' => 'moderateur@example.com',
            'mot_de_passe' => \Illuminate\Support\Facades\Hash::make('password'),
            'statut' => 'moderateur',
        ]);

        // Créer quelques clients
        \App\Models\User::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean.dupont@example.com',
            'mot_de_passe' => \Illuminate\Support\Facades\Hash::make('password'),
            'statut' => 'client',
        ]);

        \App\Models\User::create([
            'nom' => 'Martin',
            'prenom' => 'Marie',
            'email' => 'marie.martin@example.com',
            'mot_de_passe' => \Illuminate\Support\Facades\Hash::make('password'),
            'statut' => 'client',
        ]);
    }
}
