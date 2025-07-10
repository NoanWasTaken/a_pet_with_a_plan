<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    // Afficher le panier
    public function index(): View
    {
        $cart = $this->getOrCreateCart();
        $cart->load(['items.produit']);
        
        return view('public.cart.index', compact('cart'));
    }

    // Ajouter un produit au panier
    public function add(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produit,id',
            'quantity' => 'integer|min:1|max:99'
        ]);

        $product = Produit::findOrFail($request->produit_id);
        $quantity = $request->input('quantity', 1);
        
        $cart = $this->getOrCreateCart();
        
        // Vérifier si le produit est déjà dans le panier
        $cartItem = $cart->items()->where('produit_id', $product->id)->first();
        
        if ($cartItem) {
            // Mettre à jour la quantité
            $cartItem->increment('quantity', $quantity);
            $message = 'Quantité mise à jour dans le panier';
        } else {
            // Ajouter un nouvel article
            $cart->items()->create([
                'produit_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->prix, // Prix en centimes
            ]);
            $message = 'Produit ajouté au panier';
        }

        $cart->refresh();
        $cart->load(['items.produit']);

        // Si c'est une requête AJAX, retourner du JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cart->total_items,
                'cart_total' => $cart->total_euros
            ]);
        }

        // Sinon, rediriger vers le panier avec un message de succès
        return redirect()->route('cart.index')->with('success', $message);
    }

    // Mettre à jour la quantité d'un article
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        // Récupérer l'article du panier
        $cartItem = CartItem::findOrFail($id);
        
        // Vérifier que l'article appartient au panier de l'utilisateur
        $cart = $this->getOrCreateCart();
        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['error' => 'Article non trouvé'], 404);
        }

        $cartItem->update(['quantity' => $request->quantity]);
        
        $cart->refresh();
        $cart->load(['items.produit']);

        return response()->json([
            'success' => true,
            'cart_count' => $cart->total_items,
            'cart_total' => $cart->total_euros,
            'item_total' => $cartItem->total_euros
        ]);
    }

    // Supprimer un article du panier
    public function remove($id): JsonResponse
    {
        // Récupérer l'article du panier
        $cartItem = CartItem::findOrFail($id);
        
        // Vérifier que l'article appartient au panier de l'utilisateur
        $cart = $this->getOrCreateCart();
        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['error' => 'Article non trouvé'], 404);
        }

        $cartItem->delete();
        
        $cart->refresh();
        $cart->load(['items.produit']);

        return response()->json([
            'success' => true,
            'message' => 'Article supprimé du panier',
            'cart_count' => $cart->total_items,
            'cart_total' => $cart->total_euros
        ]);
    }

    // Vider le panier
    public function clear(): RedirectResponse
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();

        return redirect()->route('cart.index')->with('success', 'Panier vidé');
    }

    // Récupérer ou créer le panier
    private function getOrCreateCart(): Cart
    {
        // Seuls les utilisateurs connectés peuvent avoir un panier
        $cart = auth()->user()->cart;
        if (!$cart) {
            $cart = auth()->user()->cart()->create([]);
        }
        
        return $cart;
    }

    // Récupérer le nombre d'articles dans le panier (pour la navigation)
    public function count(): JsonResponse
    {
        $cart = $this->getOrCreateCart();
        
        return response()->json([
            'count' => $cart->total_items,
            'total' => $cart->total_euros
        ]);
    }
}
