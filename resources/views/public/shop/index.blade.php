@extends('layouts.public')

@section('title', 'Boutique - A Pet with a Plan')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <section class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-6 lg:mb-0">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Notre Boutique</h1>
                        <p class="text-gray-600">Découvrez tous nos produits pour le bien-être de vos animaux</p>
                    </div>

                    <!-- Filtres et recherche -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <form method="GET" action="{{ route('shop.index') }}" class="flex flex-col sm:flex-row gap-4">
                            <!-- Recherche -->
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Rechercher un produit..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent w-full sm:w-64">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <!-- Catégorie -->
                            <select name="categorie"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                <option value="">Toutes catégories</option>
                                <option value="Chien" {{ request('categorie') === 'Chien' ? 'selected' : '' }}>Chien</option>
                                <option value="Chat" {{ request('categorie') === 'Chat' ? 'selected' : '' }}>Chat</option>
                            </select>

                            <!-- Tri -->
                            <select name="sort"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                <option value="">Trier par</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nom A-Z
                                </option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nom Z-A
                                </option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Prix
                                    croissant</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Prix
                                    décroissant</option>
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Plus récent
                                </option>
                            </select>

                            <button type="submit"
                                class="bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                                Filtrer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Message de personnalisation -->
        @auth
            @php
                $user = auth()->user();
                $categoriesPreferees = $user->getCategoriesPreferees();
            @endphp
            @if(!empty($categoriesPreferees) && !request()->hasAny(['search', 'categorie', 'sort']))
                <section class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b">
                    <div class="container mx-auto px-4 py-4">
                        <div class="flex items-center justify-center text-center">
                            <div class="flex items-center space-x-2 text-sm text-gray-700">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                                <span>✨ Produits personnalisés pour 
                                    @if(count($categoriesPreferees) === 1)
                                        @if($categoriesPreferees[0] === 'Chien')
                                            votre chien
                                        @else
                                            votre chat
                                        @endif
                                    @else
                                        vos animaux
                                    @endif
                                    en priorité
                                </span>
                                <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800 underline">
                                    Modifier mes préférences
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endauth

        <!-- Résultats -->
        <section class="py-8">
            <div class="container mx-auto px-4">
                <!-- Info résultats -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                    <p class="text-gray-600 mb-4 sm:mb-0">
                        {{ $produits->total() }} produit{{ $produits->total() > 1 ? 's' : '' }}
                        trouvé{{ $produits->total() > 1 ? 's' : '' }}
                    </p>

                    @if(request()->hasAny(['search', 'categorie', 'sort']))
                        <a href="{{ route('shop.index') }}" class="text-gray-600 hover:text-gray-700 underline">
                            Effacer les filtres
                        </a>
                    @endif
                </div>

                <!-- Grille de produits -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($produits as $produit)
                        <a href="{{ route('shop.show', $produit) }}">
                            <div
                                class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden group h-full flex flex-col">
                                <div
                                    class="relative bg-gradient-to-br from-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $produit->categorie === 'Chien' ? 'amber' : 'pink' }}-100">
                                    @if($produit->image_path)
                                        <img src="{{ asset('storage/' . $produit->image_path) }}" alt="{{ $produit->nom }}"
                                            class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div
                                            class="flex items-center justify-center h-64 group-hover:scale-105 transition duration-300">
                                            <span class="text-8xl">
                                                {{ $produit->categorie === 'Chien' ? '🐕' : '🐱' }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Badge catégorie -->
                                    <div class="absolute top-3 left-3">
                                        <span
                                            class="text-xs font-medium text-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-600 bg-white bg-opacity-90 px-2 py-1 rounded-full">
                                            {{ $produit->categorie }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6 flex flex-col justify-between flex-1">
                                    <div>
                                        <div class="flex justify-between mb-2 flex-1">
                                            <h3 class="text-sm font-bold text-black line-clamp-2 uppercase">
                                                {{ $produit->nom }}</h3>
                                            <span
                                                class="text-sm font-bold whitespace-nowrap text-black">
                                                {{ $produit->prix_formate }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $produit->description }}</p>
                                    </div>

                                    <div class="flex gap-2">
                                        @auth
                                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                                <button type="submit"
                                                    class="w-full bg-gray-800 text-white py-2 rounded-md font-semibold hover:bg-gray-700 transition duration-300 block">
                                                    Ajouter au panier
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-lg text-center text-sm hover:bg-gray-700 transition duration-300">
                                                Se connecter
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <div class="text-6xl mb-4">🔍</div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun produit trouvé</h3>
                            <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche.</p>
                            <a href="{{ route('shop.index') }}"
                                class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-300">
                                Voir tous les produits
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($produits->hasPages())
                    <div class="mt-12">
                        {{ $produits->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </section>
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

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush