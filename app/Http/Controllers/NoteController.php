<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\User;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NoteController extends Controller
{
    // Afficher la liste des notes
    public function index(): View
    {
        $notes = Note::with(['utilisateur', 'produit'])->paginate(10);
        return view('notes.index', compact('notes'));
    }

    // Afficher le formulaire pour créer une nouvelle note
    public function create(): View
    {
        $utilisateurs = User::all();
        $produits = Produit::all();
        return view('notes.create', compact('utilisateurs', 'produits'));
    }

    // Stocker une nouvelle note en base de données
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_utilisateur' => 'required|exists:utilisateur,id',
            'id_produit' => 'required|exists:produit,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string',
        ]);

        Note::create($validated);

        return redirect()->route('notes.index')
            ->with('success', 'Note créée avec succès.');
    }

    // Afficher les détails d'une note spécifique
    public function show(Note $note): View
    {
        $note->load(['utilisateur', 'produit']);
        return view('notes.show', compact('note'));
    }

    // Afficher le formulaire pour éditer une note spécifique
    public function edit(Note $note): View
    {
        $utilisateurs = User::all();
        $produits = Produit::all();
        return view('notes.edit', compact('note', 'utilisateurs', 'produits'));
    }

    // Mettre à jour une note spécifique en base de données
    public function update(Request $request, Note $note): RedirectResponse
    {
        $validated = $request->validate([
            'id_utilisateur' => 'required|exists:utilisateur,id',
            'id_produit' => 'required|exists:produit,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string',
        ]);

        $note->update($validated);

        return redirect()->route('notes.index')
            ->with('success', 'Note mise à jour avec succès.');
    }

    // Supprimer une note spécifique
    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Note supprimée avec succès.');
    }

    // Afficher les notes pour un produit spécifique
    public function byProduct(Produit $produit): View
    {
        $notes = Note::where('id_produit', $produit->id)
            ->with('utilisateur')
            ->paginate(10);
        
        return view('notes.by-product', compact('notes', 'produit'));
    }

    // Afficher les notes d'un utilisateur spécifique
    public function byUser(Utilisateur $utilisateur): View
    {
        $notes = Note::where('id_utilisateur', $utilisateur->id)
            ->with('produit')
            ->paginate(10);
        
        return view('notes.by-user', compact('notes', 'utilisateur'));
    }
}
