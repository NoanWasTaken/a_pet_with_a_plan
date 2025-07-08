<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProduitController extends Controller
{
    // Afficher la liste des produits.
    public function index(): View
    {
        $produits = Produit::paginate(10);
        return view('produits.index', compact('produits'));
    }

    // Afficher le formulaire de création d'un nouveau produit.
    public function create(): View
    {
        return view('produits.create');
    }

    // Enregistrer un nouveau produit en base de données.
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:72',
            'prix' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produits', 'public');
            $validated['image'] = $imagePath;
        }

        Produit::create($validated);

        return redirect()->route('produits.index')
            ->with('success', 'Produit créé avec succès.');
    }

    // Afficher les détails d'un produit spécifique.
    public function show(Produit $produit): View
    {
        return view('produits.show', compact('produit'));
    }

    // Afficher le formulaire d'édition d'un produit.
    public function edit(Produit $produit): View
    {
        return view('produits.edit', compact('produit'));
    }

    // Mettre à jour un produit spécifique en base de données.
    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:72',
            'prix' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gérer l'upload de l'image si une nouvelle image est fournie
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produits', 'public');
            $validated['image'] = $imagePath;
        }

        $produit->update($validated);

        return redirect()->route('produits.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    // Supprimer un produit spécifique de la base de données.
    public function destroy(Produit $produit): RedirectResponse
    {
        $produit->delete();

        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
}
