<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Affiche la liste des utilisateurs.
    public function index()
    {
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    // Affiche le formulaire pour créer un nouvel utilisateur.
    public function create()
    {
        return view('users.create');
    }

    // Enregistre un nouvel utilisateur en base de données.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|max:320|unique:utilisateur,email',
            'mot_de_passe' => 'required|string|min:8|confirmed',
            'statut' => 'required|in:admin,client,moderateur',
        ]);

        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);

        $user = User::create($validated);

        return redirect()->route('users.show', $user)->with('success', 'Utilisateur créé avec succès.');
    }

    // Affiche les détails d'un utilisateur spécifique.
    public function show(User $user)
    {
        $user->load(['articles', 'notes', 'commandes.produits']);
        return view('users.show', compact('user'));
    }

    // Affiche le formulaire pour éditer un utilisateur spécifique.
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Met à jour un utilisateur spécifique en base de données.
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => ['required', 'email', 'max:320', Rule::unique('utilisateur')->ignore($user->id)],
            'statut' => 'required|in:admin,client,moderateur',
        ]);

        if ($request->filled('mot_de_passe')) {
            $request->validate([
                'mot_de_passe' => 'string|min:8|confirmed',
            ]);
            $validated['mot_de_passe'] = Hash::make($request->mot_de_passe);
        }

        $user->update($validated);

        return redirect()->route('users.show', $user)->with('success', 'Utilisateur modifié avec succès.');
    }

    // Supprime un utilisateur spécifique de la base de données.
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    // Récupère les utilisateurs par statut.
    public function byStatus($status)
    {
        $users = User::where('statut', $status)->paginate(15);
        return view('users.index', compact('users'));
    }
}
