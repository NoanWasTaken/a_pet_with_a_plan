@extends('layouts.public')

@section('title', 'Mes commandes - A Pet with a Plan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Mes commandes</h1>
                <p class="text-gray-600">Suivez l'état de vos commandes et consultez votre historique d'achats</p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            @if($commandes->count() > 0)
                <div class="space-y-6">
                    @foreach($commandes as $commande)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <!-- En-tête de la commande -->
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            Commande #{{ $commande->id }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Passée le {{ $commande->created_at->format('d/m/Y à H:i') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                            @if($commande->statut === 'confirmée') bg-green-100 text-green-800
                                            @elseif($commande->statut === 'en_cours') bg-yellow-100 text-yellow-800
                                            @elseif($commande->statut === 'expédiée') bg-blue-100 text-blue-800
                                            @elseif($commande->statut === 'livrée') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($commande->statut) }}
                                        </span>
                                        <span class="text-lg font-bold text-green-600">
                                            {{ $commande->total_formate }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Articles de la commande -->
                            <div class="p-6">
                                @if($commande->produits && $commande->produits->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($commande->produits as $produit)
                                            <div class="flex items-center gap-4">
                                                <!-- Icône du produit -->
                                                <div class="w-16 h-16 bg-gradient-to-br from-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <span class="text-2xl">
                                                        {{ $produit->categorie === 'Chien' ? '🐕' : '🐱' }}
                                                    </span>
                                                </div>
                                                
                                                <!-- Informations du produit -->
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-lg font-medium text-gray-800">{{ $produit->nom }}</h4>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-xs font-medium text-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-600 bg-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-100 px-2 py-1 rounded-full">
                                                            {{ $produit->categorie }}
                                                        </span>
                                                    </div>
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
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-600 italic">Aucun produit associé à cette commande.</p>
                                @endif
                                
                                <!-- Actions -->
                                <div class="flex flex-col sm:flex-row gap-3 mt-6 pt-6 border-t border-gray-200">
                                    @if($commande->statut === 'expédiée' && $commande->numero_suivi)
                                        <a href="#" class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Suivre le colis
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('shop.index') }}" 
                                       class="flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Racheter ces articles
                                    </a>
                                    
                                    @if($commande->statut === 'livrée')
                                        <button class="flex items-center justify-center px-4 py-2 border border-yellow-300 text-yellow-700 rounded-lg hover:bg-yellow-50 transition duration-300">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                            Laisser un avis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($commandes->hasPages())
                    <div class="mt-8">
                        {{ $commandes->links() }}
                    </div>
                @endif
            @else
                <!-- Aucune commande -->
                <div class="max-w-md mx-auto text-center py-16">
                    <div class="text-6xl mb-6">📦</div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Aucune commande</h2>
                    <p class="text-gray-600 mb-8">Vous n'avez pas encore passé de commande. Découvrez nos produits et faites votre premier achat !</p>
                    <a href="{{ route('shop.index') }}" 
                       class="bg-purple-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-purple-700 transition duration-300">
                        Voir la boutique
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
