<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\User;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommandeController extends Controller
{
    // Afficher la liste des commandes
    public function index(): View
    {
        $commandes = Commande::with(['utilisateur', 'produits'])
            ->orderBy('date_commande', 'desc')
            ->paginate(10);
        return view('commandes.index', compact('commandes'));
    }

    // Afficher le formulaire pour créer une nouvelle commande
    public function create(): View
    {
        $utilisateurs = User::all();
        $produits = Produit::all();
        return view('commandes.create', compact('utilisateurs', 'produits'));
    }

    // Stocker une nouvelle commande en base de données
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_utilisateur' => 'required|exists:utilisateur,id',
            'date_commande' => 'required|date',
            'statut' => 'sometimes|in:en_attente,confirmee,en_cours,livree,annulee,echouee',
            'produits' => 'required|array',
            'produits.*.id' => 'required|exists:produit,id',
            'produits.*.quantite' => 'required|integer|min:1',
        ]);

        // Créer la commande
        $commande = Commande::create([
            'id_utilisateur' => $validated['id_utilisateur'],
            'date_commande' => $validated['date_commande'],
            'statut' => $validated['statut'] ?? 'en_attente',
        ]);

        // Ajouter les produits à la commande
        foreach ($validated['produits'] as $produitData) {
            $produit = Produit::findOrFail($produitData['id']);
            $commande->produits()->attach($produit->id, [
                'quantite' => $produitData['quantite'],
                'prix_unitaire' => $produit->prix, // Stocke le prix en centimes au moment de la commande
            ]);
        }

        return redirect()->route('commandes.index')
            ->with('success', 'Commande créée avec succès.');
    }

    // Afficher les détails d'une commande spécifique
    public function show(Commande $commande): View
    {
        $commande->load(['utilisateur', 'produits']);
        return view('commandes.show', compact('commande'));
    }

    // Afficher le formulaire pour éditer une commande spécifique
    public function edit(Commande $commande): View
    {
        $utilisateurs = User::all();
        $produits = Produit::all();
        $commande->load(['produits']);
        return view('commandes.edit', compact('commande', 'utilisateurs', 'produits'));
    }

    // Mettre à jour une commande spécifique en base de données
    public function update(Request $request, Commande $commande): RedirectResponse
    {
        $validated = $request->validate([
            'id_utilisateur' => 'required|exists:utilisateur,id',
            'date_commande' => 'required|date',
            'statut' => 'sometimes|in:en_attente,confirmee,en_cours,livree,annulee,echouee',
            'produits' => 'required|array',
            'produits.*.id' => 'required|exists:produit,id',
            'produits.*.quantite' => 'required|integer|min:1',
        ]);

        $commande->update([
            'id_utilisateur' => $validated['id_utilisateur'],
            'date_commande' => $validated['date_commande'],
            'statut' => $validated['statut'] ?? $commande->statut,
        ]);

        // Supprimer les anciennes relations
        $commande->produits()->detach();
        
        // Ajouter les nouvelles relations
        foreach ($validated['produits'] as $produitData) {
            $produit = Produit::findOrFail($produitData['id']);
            $commande->produits()->attach($produit->id, [
                'quantite' => $produitData['quantite'],
                'prix_unitaire' => $produit->prix, // Stocke le prix en centimes au moment de la commande
            ]);
        }

        return redirect()->route('commandes.index')
            ->with('success', 'Commande mise à jour avec succès.');
    }

    // Supprimer une commande spécifique de la base de données
    public function destroy(Commande $commande): RedirectResponse
    {
        $commande->delete();

        return redirect()->route('commandes.index')
            ->with('success', 'Commande supprimée avec succès.');
    }

    // Mettre à jour le statut d'une commande
    public function updateStatut(Request $request, Commande $commande): RedirectResponse
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,confirmee,en_cours,livree,annulee,echouee',
        ]);

        $commande->update([
            'statut' => $validated['statut'],
        ]);

        return redirect()->route('commandes.index')
            ->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    // Afficher les commandes d'un utilisateur spécifique
    public function byUser(User $utilisateur): View
    {
        $commandes = Commande::where('id_utilisateur', $utilisateur->id)
            ->with(['produits'])
            ->orderBy('date_commande', 'desc')
            ->paginate(10);
        
        return view('commandes.index', compact('commandes', 'utilisateur'));
    }
}
