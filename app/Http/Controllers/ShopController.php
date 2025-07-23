<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    // Afficher la liste des produits
    public function index(Request $request): View
    {
        $query = Produit::query();

        // Filtrer par catégorie si spécifiée
        if ($request->filled('categorie') && in_array($request->categorie, ['Chien', 'Chat'])) {
            $query->where('categorie', $request->categorie);
        }

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Tri
        switch ($request->get('sort', 'default')) {
            case 'price_asc':
                $query->orderBy('prix', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('prix', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'name_asc':
                $query->orderBy('nom', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nom', 'desc');
                break;
            case 'default':
            default:
                // Tri personnalisé basé sur les préférences utilisateur
                if (auth()->check()) {
                    $user = auth()->user();
                    $categoriesPreferees = $user->getCategoriesPreferees();
                    
                    if (!empty($categoriesPreferees)) {
                        // Si l'utilisateur a des préférences, on priorise ces catégories
                        if (count($categoriesPreferees) === 1) {
                            // L'utilisateur préfère un seul type d'animal
                            $query->orderByRaw("CASE WHEN categorie = ? THEN 0 ELSE 1 END, nom", [$categoriesPreferees[0]]);
                        } else {
                            // L'utilisateur aime les deux types d'animaux, on garde l'ordre par nom
                            $query->orderBy('nom');
                        }
                    } else {
                        // Pas de préférence définie, ordre par nom
                        $query->orderBy('nom');
                    }
                } else {
                    // Utilisateur non connecté, ordre par nom
                    $query->orderBy('nom');
                }
                break;
        }

        $produits = $query->paginate(12);
        
        return view('public.shop.index', compact('produits'));
    }

    // Afficher les détails d'un produit
    public function show(Produit $produit): View
    {
        // Charger les relations nécessaires
        $produit->load(['notes.utilisateur']);
        
        // Récupérer des produits similaires (même catégorie)
        $relatedProducts = Produit::where('categorie', $produit->categorie)
            ->where('id', '!=', $produit->id)
            ->limit(4)
            ->get();

        return view('public.shop.show', compact('produit', 'relatedProducts'));
    }
}
