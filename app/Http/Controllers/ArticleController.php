<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArticleController extends Controller
{
    // Affiche la liste des articles.
    public function index(): View
    {
        $articles = Article::with('utilisateur')->paginate(10);
        return view('articles.index', compact('articles'));
    }

    // Formulaire pour créer un nouvel article.
    public function create(): View
    {
        $utilisateurs = User::all();
        return view('articles.create', compact('utilisateurs'));
    }

    // Stocker un nouvel article dans la base de données.
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:150',
            'description' => 'required|string',
            'contenu' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banniere_article' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_publication' => 'required|date',
            'id_utilisateur' => 'required|exists:utilisateur,id',
        ]);

        // Gérer l'upload des images
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $validated['image'] = $imagePath;
        }

        if ($request->hasFile('banniere_article')) {
            $bannierePath = $request->file('banniere_article')->store('articles/bannieres', 'public');
            $validated['banniere_article'] = $bannierePath;
        }

        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article créé avec succès.');
    }

    // Afficher les détails d'un article spécifique.
    public function show(Article $article): View
    {
        $article->load('utilisateur');
        return view('articles.show', compact('article'));
    }

    // Afficher le formulaire d'édition d'un article.
    public function edit(Article $article): View
    {
        $utilisateurs = User::all();
        return view('articles.edit', compact('article', 'utilisateurs'));
    }

    // Mettre à jour un article spécifique en base de données.
    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:150',
            'description' => 'required|string',
            'contenu' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banniere_article' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_publication' => 'required|date',
            'id_utilisateur' => 'required|exists:utilisateur,id',
        ]);

        // Gérer l'upload des images si de nouvelles images sont fournies
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $validated['image'] = $imagePath;
        }

        if ($request->hasFile('banniere_article')) {
            $bannierePath = $request->file('banniere_article')->store('articles/bannieres', 'public');
            $validated['banniere_article'] = $bannierePath;
        }

        $article->update($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    // Supprimer un article spécifique de la base de données.
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article supprimé avec succès.');
    }
}
