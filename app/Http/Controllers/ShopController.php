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
        switch ($request->get('sort', 'name')) {
            case 'price_asc':
                $query->orderBy('prix', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('prix', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->orderBy('nom');
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
