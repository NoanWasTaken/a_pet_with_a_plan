<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Configuration Stripe
        Stripe::setApiKey(config('stripe.secret_key'));
    }

    // Afficher la page de checkout
    public function index(): View
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide');
        }

        $cart->load(['items.produit']);

        return view('public.checkout.index', compact('cart'));
    }

    // Traiter le paiement
    public function process(Request $request)
    {
        \Log::info('=== DEBUT PROCESS CHECKOUT ===');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request ajax: ' . ($request->ajax() ? 'true' : 'false'));
        \Log::info('Request wantsJson: ' . ($request->wantsJson() ? 'true' : 'false'));
        \Log::info('Request data: ', $request->all());
        
        $cart = $this->getCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            \Log::error('Panier vide ou inexistant');
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Votre panier est vide'
                ], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide');
        }

        try {
            $request->validate([
                'billing_name' => 'required|string|max:255',
                'billing_email' => 'required|email|max:255',
                'billing_address' => 'required|string|max:255',
                'billing_city' => 'required|string|max:255',
                'billing_postal_code' => 'required|string|max:10',
            ]);
            \Log::info('Validation réussie');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation', $e->errors());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Données de facturation invalides: ' . implode(', ', array_flatten($e->errors()))
                ], 422);
            }
            throw $e;
        }

        try {
            \Log::info('=== DEBUT TRY BLOCK ===');
            
            // S'assurer que la clé API Stripe est définie
            $secretKey = config('stripe.secret_key');
            if (empty($secretKey)) {
                throw new \Exception('Clé secrète Stripe non configurée');
            }
            \Log::info('Clé Stripe configurée');
            Stripe::setApiKey($secretKey);
            
            // Créer la commande en base avant le paiement
            \Log::info('Création de la commande en base');
            $user = auth()->user();
            
            // Calculer le total dans la devise de l'utilisateur
            $totalInUserCurrency = $user->convertFromEuros($cart->total / 100);
            $totalInUserCurrencyCents = (int) round($totalInUserCurrency * 100);
            
            $commande = Commande::create([
                'id_utilisateur' => auth()->id(),
                'total' => $totalInUserCurrencyCents, // Total en centimes de la devise utilisateur
                'statut' => 'en_attente',
                'date_commande' => now(),
                'devise' => $user->devise_preferee ?? 'EUR',
            ]);
            \Log::info('Commande créée avec ID: ' . $commande->id);

            // Ajouter les produits à la commande avec les prix dans la devise de l'utilisateur
            foreach ($cart->items as $item) {
                // Convertir le prix en centimes de la devise de l'utilisateur
                $priceInUserCurrency = $user->convertFromEuros($item->price / 100);
                $priceInUserCurrencyCents = (int) round($priceInUserCurrency * 100);
                
                $commande->produits()->attach($item->produit_id, [
                    'quantite' => $item->quantity,
                    'prix_unitaire' => $priceInUserCurrencyCents, // Prix en centimes de la devise utilisateur
                ]);
            }

            // Préparer les line items pour Stripe
            $userCurrency = strtolower($user->devise_preferee ?? 'eur');
            $lineItems = [];
            foreach ($cart->items as $item) {
                // Convertir le prix en centimes de la devise de l'utilisateur
                $priceInUserCurrency = $user->convertFromEuros($item->price / 100);
                $priceInUserCurrencyCents = (int) round($priceInUserCurrency * 100);
                
                $lineItems[] = [
                    'price_data' => [
                        'currency' => $userCurrency,
                        'product_data' => [
                            'name' => $item->produit->nom,
                            'description' => $item->produit->description,
                        ],
                        'unit_amount' => $priceInUserCurrencyCents, // Prix en centimes de la devise utilisateur
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            // Créer la session Stripe Checkout
            $sessionParams = [
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $commande->id,
                'cancel_url' => route('checkout.cancel') . '?order_id=' . $commande->id,
                'customer_email' => $request->billing_email,
                'metadata' => [
                    'order_id' => $commande->id,
                    'user_id' => auth()->id(),
                ],
            ];
            
            \Log::info('Création session Stripe', $sessionParams);
            $session = Session::create($sessionParams);
            \Log::info('Session créée', ['session_id' => $session->id, 'url' => $session->url]);

            // Stocker l'ID de session Stripe dans la commande
            $commande->update(['stripe_session_id' => $session->id]);

            // Pour les requêtes AJAX, retourner l'URL de redirection
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => $session->url
                ]);
            }

            return redirect($session->url);

        } catch (\Exception $e) {
            // Supprimer la commande si elle a été créée
            if (isset($commande)) {
                $commande->delete();
            }

            // Pour les requêtes AJAX, retourner l'erreur en JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Erreur lors du traitement du paiement : ' . $e->getMessage()
                ], 400);
            }

            return redirect()->route('checkout.index')
                ->with('error', 'Erreur lors du traitement du paiement : ' . $e->getMessage());
        }
    }

    // Page de succès après paiement
    public function success(Request $request): View
    {
        $sessionId = $request->get('session_id');
        $orderId = $request->get('order_id');

        if (!$sessionId || !$orderId) {
            return redirect()->route('home')->with('error', 'Session invalide');
        }

        $commande = Commande::findOrFail($orderId);

        // Vérifier que la commande appartient à l'utilisateur
        if ($commande->id_utilisateur !== auth()->id()) {
            abort(403);
        }

        try {
            // Récupérer la session Stripe pour vérifier le paiement
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                // Marquer la commande comme payée
                $commande->update([
                    'statut' => 'confirmee',
                    'stripe_payment_intent' => $session->payment_intent,
                ]);

                // Vider le panier
                $cart = $this->getCart();
                if ($cart) {
                    $cart->items()->delete();
                    $cart->delete();
                }

                return view('public.checkout.success', compact('commande'));
            } else {
                // Paiement échoué
                $commande->update(['statut' => 'echouee']);
                return redirect()->route('checkout.index')
                    ->with('error', 'Le paiement n\'a pas pu être traité');
            }

        } catch (\Exception $e) {
            return redirect()->route('checkout.index')
                ->with('error', 'Erreur lors de la vérification du paiement');
        }
    }

    // Page d'annulation
    public function cancel(Request $request): RedirectResponse
    {
        $orderId = $request->get('order_id');

        if ($orderId) {
            $commande = Commande::find($orderId);
            if ($commande && $commande->id_utilisateur === auth()->id()) {
                $commande->update(['statut' => 'annulee']);
            }
        }

        return redirect()->route('cart.index')
            ->with('warning', 'Commande annulée');
    }

    // Récupérer le panier de l'utilisateur connecté
    private function getCart(): ?Cart
    {
        return auth()->user()->cart;
    }
}
