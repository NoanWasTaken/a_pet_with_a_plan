<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    // Afficher l'historique des commandes de l'utilisateur
    public function index(): View
    {
        $commandes = auth()->user()->commandes()
            ->with(['produits'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('commandes'));
    }

    // Afficher les détails d'une commande
    public function show(Commande $commande): View
    {
        // Vérifier que la commande appartient à l'utilisateur connecté
        if ($commande->id_utilisateur !== auth()->id()) {
            abort(403, 'Accès non autorisé à cette commande');
        }

        $commande->load(['produits', 'utilisateur']);

        return view('orders.show', compact('commande'));
    }
}
