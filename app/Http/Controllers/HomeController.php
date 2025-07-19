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
        // Récupérer les produits pour chiens (4 max)
        $dogProducts = Produit::where('categorie', 'Chien')->latest()->limit(4)->get();
        
        // Récupérer les produits pour chats (4 max)
        $catProducts = Produit::where('categorie', 'Chat')->latest()->limit(4)->get();
        
        // Récupérer les derniers articles (3 max)
        $latestArticles = Article::latest()->limit(3)->get();

        return view('public.home', compact('dogProducts', 'catProducts', 'latestArticles'));
    }
}
