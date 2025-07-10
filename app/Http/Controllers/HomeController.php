<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    // Afficher la page d'accueil
    public function index(): View
    {
        // Récupérer les derniers produits (6 max)
        $featuredProducts = Produit::latest()->limit(6)->get();
        
        // Récupérer les derniers articles (3 max)
        $latestArticles = Article::latest()->limit(3)->get();

        return view('public.home', compact('featuredProducts', 'latestArticles'));
    }
}
