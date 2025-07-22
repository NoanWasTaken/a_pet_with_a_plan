@extends('layouts.public')

@section('title', 'Mon Panier - A Pet with a Plan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Mon Panier</h1>
                <p class="text-gray-600">Vérifiez vos articles avant de passer commande</p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            @if($cart && $cart->items->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Articles du panier -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-800">
                                    Articles ({{ $cart->total_items }})
                                </h2>
                            </div>
                            
                            <div class="divide-y divide-gray-200">
                                @foreach($cart->items as $item)
                                    <div class="p-6 cart-item" data-item-id="{{ $item->id }}">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                            <!-- Image du produit -->
                                            <div class="flex-shrink-0">
                                                <div class="w-20 h-20 bg-gradient-to-br from-{{ $item->produit->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $item->produit->categorie === 'Chien' ? 'orange' : 'purple' }}-200 rounded-lg overflow-hidden">
                                                    @if($item->produit->image_path)
                                                        <img src="{{ asset('storage/' . $item->produit->image_path) }}" 
                                                             alt="{{ $item->produit->nom }}"
                                                             class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center">
                                                            <span class="text-3xl">
                                                                {{ $item->produit->categorie === 'Chien' ? '🐕' : '🐱' }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Informations du produit -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                                    {{ $item->produit->nom }}
                                                </h3>
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="text-xs font-medium text-{{ $item->produit->categorie === 'Chien' ? 'orange' : 'purple' }}-600 bg-{{ $item->produit->categorie === 'Chien' ? 'orange' : 'purple' }}-100 px-2 py-1 rounded-full">
                                                        {{ $item->produit->categorie }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-600 line-clamp-2">
                                                    {{ Str::limit($item->produit->description, 100) }}
                                                </p>
                                            </div>
                                            
                                            <!-- Quantité et prix -->
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                                                <!-- Contrôles de quantité -->
                                                <div class="flex items-center">
                                                    <button type="button" 
                                                            class="quantity-btn decrease-btn w-8 h-8 rounded-l-lg border border-gray-300 bg-gray-50 hover:bg-gray-100 flex items-center justify-center"
                                                            data-action="decrease" 
                                                            data-item-id="{{ $item->id }}">
                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" 
                                                           class="quantity-input w-16 h-8 text-center border-t border-b border-gray-300 focus:ring-2 focus:ring-gray-500 focus:border-transparent" 
                                                           value="{{ $item->quantity }}" 
                                                           min="1" 
                                                           max="99"
                                                           data-item-id="{{ $item->id }}">
                                                    <button type="button" 
                                                            class="quantity-btn increase-btn w-8 h-8 rounded-r-lg border border-gray-300 bg-gray-50 hover:bg-gray-100 flex items-center justify-center"
                                                            data-action="increase" 
                                                            data-item-id="{{ $item->id }}">
                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                
                                                <!-- Prix -->
                                                <div class="text-right">
                                                    <div class="text-lg font-bold text-green-600 item-total">
                                                        {{ $item->total_formate }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $item->produit->prix_formate }} / unité
                                                    </div>
                                                </div>
                                                
                                                <!-- Bouton supprimer -->
                                                <button type="button" 
                                                        class="remove-btn text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded-lg transition duration-300"
                                                        data-item-id="{{ $item->id }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Actions du panier -->
                        <div class="mt-6 flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('shop.index') }}" 
                               class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center font-medium hover:bg-gray-200 transition duration-300">
                                Continuer les achats
                            </a>
                            <form action="{{ route('cart.clear') }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full border border-red-300 text-red-600 px-6 py-3 rounded-lg font-medium hover:bg-red-50 transition duration-300"
                                        onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?')">
                                    Vider le panier
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Résumé de commande -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-8">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-800">Résumé</h2>
                            </div>
                            
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Sous-total ({{ $cart->total_items }} article{{ $cart->total_items > 1 ? 's' : '' }})</span>
                                    <span class="font-medium cart-total">{{ $cart->total_formate }}</span>
                                </div>
                                
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Livraison</span>
                                    <span class="font-medium text-green-600">Gratuite</span>
                                </div>
                                
                                <div class="border-t pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold text-gray-800">Total</span>
                                        <span class="text-lg font-bold text-green-600 cart-total">{{ $cart->total_formate }}</span>
                                    </div>
                                </div>
                                
                                @auth
                                    <a href="{{ route('checkout.index') }}" 
                                       class="w-full bg-gray-800 text-white px-6 py-4 rounded-lg font-semibold text-center block hover:bg-gray-700 transition duration-300">
                                        Passer commande
                                    </a>
                                @else
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 mb-4">Connectez-vous pour passer commande</p>
                                        <div class="space-y-2">
                                            <a href="{{ route('login') }}" 
                                               class="w-full bg-gray-600 text-white px-6 py-3 rounded-lg font-medium text-center block hover:bg-gray-700 transition duration-300">
                                                Se connecter
                                            </a>
                                            <a href="{{ route('register') }}" 
                                               class="w-full border border-gray-600 text-gray-600 px-6 py-3 rounded-lg font-medium text-center block hover:bg-gray-50 transition duration-300">
                                                Créer un compte
                                            </a>
                                        </div>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Panier vide -->
                <div class="max-w-md mx-auto text-center py-16">
                    <div class="text-6xl mb-6">🛒</div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Votre panier est vide</h2>
                    <p class="text-gray-600 mb-8">Découvrez nos produits et ajoutez-les à votre panier pour commencer vos achats.</p>
                    <a href="{{ route('shop.index') }}" 
                       class="bg-gray-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-gray-700 transition duration-300">
                        Voir la boutique
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    .quantity-input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des boutons de quantité
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.action;
            const itemId = this.dataset.itemId;
            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
            let currentValue = parseInt(input.value);
            
            if (action === 'increase' && currentValue < 99) {
                currentValue++;
            } else if (action === 'decrease' && currentValue > 1) {
                currentValue--;
            }
            
            input.value = currentValue;
            updateQuantity(itemId, currentValue);
        });
    });
    
    // Gestion des inputs de quantité
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            let value = parseInt(this.value);
            
            if (value < 1) value = 1;
            if (value > 99) value = 99;
            
            this.value = value;
            updateQuantity(itemId, value);
        });
    });
    
    // Gestion des boutons de suppression
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
                const itemId = this.dataset.itemId;
                removeItem(itemId);
            }
        });
    });
    
    // Fonction pour mettre à jour la quantité
    function updateQuantity(itemId, quantity) {
        fetch(`/cart/item/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour le total de l'article
                const itemRow = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                itemRow.querySelector('.item-total').textContent = data.item_total;
                
                // Mettre à jour les totaux du panier
                document.querySelectorAll('.cart-total').forEach(el => {
                    el.textContent = data.cart_total;
                });
                
                // Mettre à jour le compteur du header si présent
                updateCartCounter(data.cart_count);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour du panier.');
        });
    }
    
    // Fonction pour supprimer un article
    function removeItem(itemId) {
        fetch(`/cart/item/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Supprimer la ligne de l'article
                const itemRow = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                itemRow.remove();
                
                // Mettre à jour les totaux
                document.querySelectorAll('.cart-total').forEach(el => {
                    el.textContent = data.cart_total;
                });
                
                // Mettre à jour le compteur du header
                updateCartCounter(data.cart_count);
                
                // Si plus d'articles, recharger la page
                if (data.cart_count === 0) {
                    location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la suppression de l\'article.');
        });
    }
    
    // Fonction pour mettre à jour le compteur du panier dans le header
    function updateCartCounter(count) {
        const counter = document.querySelector('.cart-counter');
        if (counter) {
            counter.textContent = count;
            if (count === 0) {
                counter.classList.add('hidden');
            } else {
                counter.classList.remove('hidden');
            }
        }
    }
});
</script>
@endpush
