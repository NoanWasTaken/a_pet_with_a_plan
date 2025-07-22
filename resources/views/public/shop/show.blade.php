@extends('layouts.public')

@section('title', $produit->nom . ' - A Pet with a Plan')

@section('footer')
    <x-footer-light />
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb -->
        <nav class="bg-white border-b">
            <div class="container mx-auto px-8 py-4">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Accueil</a></li>
                    <li class="text-gray-500">/</li>
                    <li><a href="{{ route('shop.index') }}" class="text-gray-500 hover:text-gray-700">Boutique</a></li>
                    <li class="text-gray-500">/</li>
                    <li class="text-gray-700">{{ $produit->nom }}</li>
                </ol>
            </div>
        </nav>

        <div class="container mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 p-8">
                <!-- Images du produit -->

                <div class="space-y-4">
                    <div
                        class="bg-gradient-to-br from-{{ $produit->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $produit->categorie === 'Chien' ? 'amber' : 'pink' }}-100 rounded-sm overflow-hidden">
                        @if($produit->image_path)
                            <img src="{{ asset('storage/' . $produit->image_path) }}" alt="{{ $produit->nom }}"
                                class="w-full aspect-square object-cover">
                        @else
                            <div class="flex items-center justify-center h-96">
                                <span class="text-9xl">
                                    {{ $produit->categorie === 'Chien' ? '🐕' : '🐱' }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informations du produit -->
                <div class="space-y-6">
                    <!-- En-tête -->
                    <!-- Actions supplémentaires -->


                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $produit->nom }}</h1>



                    <!-- Description -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">Description</h2>
                        <div class="prose prose-gray max-w-none">
                            {!! nl2br(e($produit->description)) !!}
                        </div>
                    </div>
                    <!-- Ajout au panier -->
                    <div class="border-t pt-6">
                        <div class="text-4xl font-bold text-gray-800 text-right mb-6">{{ $produit->prix_formate }}</div>

                        @auth
                            <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                        Quantité
                                    </label>
                                    <div class="flex items-center space-x-3">
                                        <input type="number" id="quantity" name="quantity" min="1" max="99" value="1"
                                            class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                        <span class="text-sm text-gray-500">en stock</span>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full bg-gray-800 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-700 transition duration-300 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M9 19v1a1 1 0 102 0v-1m0 0a1 1 0 012 0v1m0 0h2">
                                        </path>
                                    </svg>
                                    <span class="uppercase">Ajouter au panier</span>
                                </button>
                            </form>
                        @else
                            <div class="text-center py-6 px-4 bg-gray-100 rounded-lg">
                                <p class="text-gray-600 mb-4">Connectez-vous pour ajouter ce produit à votre panier</p>
                                <div class="space-y-3">
                                    <a href="{{ route('login') }}"
                                        class="w-full bg-gray-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 block">
                                        Se connecter
                                    </a>
                                    <a href="{{ route('register') }}"
                                        class="w-full border border-2 text-gray-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 hover:text-white transition duration-300 block">
                                        Créer un compte
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>



                </div>
            </div>

            <!-- Produits similaires -->
            @if($relatedProducts->count() > 0)
                <div class="bg-gray-800 p-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-8">Nos autres recommandations</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedProducts->take(3) as $related)
                            <div class="bg-white overflow-hidden flex flex-col h-full rounded-sm" style="position: relative;">
                                <a href="{{ route('shop.show', $related) }}" class="flex-grow block">
                                    <div
                                        class="bg-gradient-to-br from-{{ $related->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $related->categorie === 'Chien' ? 'amber' : 'pink' }}-100">
                                        @if($related->image_path)
                                            <img src="{{ asset('storage/' . $related->image_path) }}" alt="{{ $related->nom }}"
                                                class="w-full aspect-4/3 object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-48">
                                                <span class="text-6xl">
                                                    {{ $related->categorie === 'Chien' ? '🐕' : '🐱' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4" style="padding-bottom: 50px;">
                                        <div class="flex justify-between mb-2">
                                            <h3 class="text-lg font-bold text-black line-clamp-2 uppercase">{{ $related->nom }}</h3>
                                            <span class="text-lg font-bold whitespace-nowrap text-black">
                                                {{ $related->prix_formate }}
                                            </span>
                                        </div>
                                    </div>
                                </a>

                                @auth
                                    <div style="position: absolute; bottom: 16px; right: 16px; z-index: 10;">
                                        <form action="{{ route('cart.add') }}" method="POST" onclick="event.stopPropagation();">
                                            @csrf
                                            <input type="hidden" name="produit_id" value="{{ $related->id }}">
                                            <button type="submit"
                                                class="bg-gray-800 text-white uppercase px-3 py-2 rounded-sm hover:bg-gray-700 transition duration-300 font-medium shadow-lg"
                                                onclick="event.stopPropagation();">
                                                Ajouter au panier
                                            </button>
                                        </form>
                                    </div>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                    <div class="w-full flex justify-center">
                        <a href="{{ route('shop.index', ['categorie' => $produit->categorie]) }}"
                            class="flex justify-center items-center text-white mt-8">Voir d'autres produits pour
                            {{ $produit->categorie === 'Chien' ? 'chiens' : 'chats' }}&nbsp;
                            <svg class="w-4 h-4 mr-2 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m0 7h18"></path>
                            </svg>
                        </a>
                    </div>
                </div>

            @endif
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
    </style>
@endpush