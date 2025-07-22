@extends('layouts.public')

@section('title', 'Commande #' . $commande->id . ' - A Pet with a Plan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('orders.index') }}" 
                       class="text-purple-600 hover:text-purple-700 transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Commande #{{ $commande->id }}</h1>
                </div>
                <p class="text-gray-600">Détails de votre commande du {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Détails de la commande -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informations générales -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Informations de commande</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-600 mb-1">Numéro de commande</h3>
                                    <p class="text-gray-800">#{{ $commande->id }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-600 mb-1">Date de commande</h3>
                                    <p class="text-gray-800">{{ $commande->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-600 mb-1">Statut</h3>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($commande->statut === 'confirmée') bg-green-100 text-green-800
                                        @elseif($commande->statut === 'en_cours') bg-yellow-100 text-yellow-800
                                        @elseif($commande->statut === 'expédiée') bg-blue-100 text-blue-800
                                        @elseif($commande->statut === 'livrée') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($commande->statut) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-600 mb-1">Total</h3>
                                    <p class="text-lg font-bold text-green-600">
                                        {{ number_format($commande->montant / 100, 2, ',', ' ') }} €
                                    </p>
                                </div>
                            </div>
                            
                            @if($commande->numero_suivi)
                                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="text-blue-500 mr-3">📦</div>
                                        <div>
                                            <h3 class="font-medium text-blue-800">Numéro de suivi</h3>
                                            <p class="text-sm text-blue-600">{{ $commande->numero_suivi }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Articles commandés -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Articles commandés</h2>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @forelse($commande->produits as $produit)
                                <div class="p-6">
                                    <div class="flex items-center gap-4">
                                        <!-- Icône du produit -->
                                        <div class="w-16 h-16 bg-gradient-to-br from-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-2xl">
                                                {{ $produit->categorie === 'Chien' ? '🐕' : '🐱' }}
                                            </span>
                                        </div>
                                        
                                        <!-- Informations du produit -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-medium text-gray-800">{{ $produit->nom }}</h3>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs font-medium text-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-600 bg-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-100 px-2 py-1 rounded-full">
                                                    {{ $produit->categorie }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-2">
                                                {{ Str::limit($produit->description, 100) }}
                                            </p>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Quantité : {{ $produit->pivot->quantite ?? 1 }}
                                            </p>
                                        </div>
                                        
                                        <!-- Prix -->
                                        <div class="text-right">
                                            <div class="text-lg font-medium text-gray-800">
                                                {{ number_format(($produit->pivot->prix ?? $produit->prix) / 100, 2, ',', ' ') }} €
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ number_format($produit->prix / 100, 2, ',', ' ') }} € / unité
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center text-gray-500">
                                    Aucun produit trouvé pour cette commande.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Résumé -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-8">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Résumé</h2>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sous-total</span>
                                <span class="font-medium">{{ number_format($commande->montant / 100, 2, ',', ' ') }} €</span>
                            </div>
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Livraison</span>
                                <span class="font-medium text-green-600">Gratuite</span>
                            </div>
                            
                            <div class="border-t pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-800">Total</span>
                                    <span class="text-lg font-bold text-green-600">{{ number_format($commande->montant / 100, 2, ',', ' ') }} €</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="px-6 py-4 border-t border-gray-200 space-y-3">
                            @if($commande->statut === 'expédiée' && $commande->numero_suivi)
                                <a href="#" 
                                   class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg text-center font-medium hover:bg-blue-700 transition duration-300 block">
                                    Suivre le colis
                                </a>
                            @endif
                            
                            <a href="{{ route('shop.index') }}" 
                               class="w-full border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-center font-medium hover:bg-gray-50 transition duration-300 block">
                                Racheter ces articles
                            </a>
                            
                            @if($commande->statut === 'livrée')
                                <button class="w-full border border-yellow-300 text-yellow-700 px-4 py-2 rounded-lg font-medium hover:bg-yellow-50 transition duration-300">
                                    Laisser un avis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
