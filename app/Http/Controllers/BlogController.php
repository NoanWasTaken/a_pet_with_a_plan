<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    // Afficher la liste des articles
    public function index(Request $request): View
    {
        $query = Article::query();

        // Filtrer par catégorie si spécifiée
        if ($request->filled('categorie') && in_array($request->categorie, ['Chien', 'Chat'])) {
            $query->where('categorie', $request->categorie);
        }

        // Recherche
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->search . '%')
                  ->orWhere('contenu', 'like', '%' . $request->search . '%');
            });
        }

        // Tri
        switch ($request->get('sort')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('titre', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('titre', 'desc');
                break;
            default:
                $query->latest();
        }

        $articles = $query->paginate(9);
        
        return view('public.blog.index', compact('articles'));
    }

    // Afficher un article spécifique
    public function show(Article $article): View
    {
        // Récupérer des articles similaires (même catégorie)
        $relatedArticles = Article::where('categorie', $article->categorie)
            ->where('id', '!=', $article->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('public.blog.show', compact('article', 'relatedArticles'));
    }
}
