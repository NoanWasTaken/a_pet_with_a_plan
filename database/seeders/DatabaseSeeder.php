<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Fournir les infos de base pour peupler la base de données.
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProduitSeeder::class,
            ArticleSeeder::class,
            CommandeSeeder::class,
        ]);
    }
}
