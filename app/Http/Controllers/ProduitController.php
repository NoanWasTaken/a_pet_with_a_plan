<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            'categorie' => 'required|in:Chien,Chat',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ], [
            'image.required' => 'Une image est requise.',
            'image.mimes' => 'L\'image doit être un fichier de type: jpeg, png, jpg, gif ou webp.',
            'image.max' => 'L\'image ne doit pas dépasser 5 MB.',
            'image.file' => 'Le champ image doit être un fichier valide.'
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('produits', 'public');
            $validated['image_path'] = $imagePath;
        }
        
        // Supprimer le champ image de validated car on utilise image_path
        unset($validated['image']);

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
        // Debug: Afficher les informations du fichier uploadé
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            Log::info('Upload Debug:', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension(),
                'is_valid' => $file->isValid(),
                'error' => $file->getError()
            ]);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:72',
            'prix' => 'required|numeric|min:0',
            'description' => 'required|string',
            'categorie' => 'required|in:Chien,Chat',
            'image' => 'sometimes|file|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ], [
            'image.mimes' => 'L\'image doit être un fichier de type: jpeg, png, jpg, gif ou webp.',
            'image.max' => 'L\'image ne doit pas dépasser 5 MB.',
            'image.file' => 'Le champ image doit être un fichier valide.'
        ]);

        // Gérer l'upload de l'image si une nouvelle image est fournie
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('produits', 'public');
            $validated['image_path'] = $imagePath;
        }
        
        // Supprimer le champ image de validated car on utilise image_path
        unset($validated['image']);

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
