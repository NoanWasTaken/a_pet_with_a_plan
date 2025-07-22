@extends('layouts.public')

@section('title', 'Accueil - A Pet with a Plan')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <section class="hero-banner text-white py-16 min-h-screen content-center">
            <div class="container mx-auto px-4">
                <div class="max-w-7xl mx-auto text-center">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6">
                        Le bien-être de votre animal commence ici.
                    </h1>
                    <p class="md:text-lg mb-8 text-blue-100">
                        « Chaque animal mérite une attention sur mesure. Nous partons de ce qu’il aime, de ce que vous
                        vivez, et de son état de santé réel. Pas de généralité, pas de recette miracle. »
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('shop.index') }}"
                            class="bg-gray-800 text-white uppercase px-4 py-2 rounded-md font-semibold hover:bg-gray-700 transition duration-300">
                            Découvrir la boutique
                        </a>
                        <a href="{{ route('blog.index') }}"
                            class="bg-white text-gray-600 uppercase px-4 py-2 rounded-md font-semibold hover:bg-gray-700 transition duration-300 hover:text-white">
                            Lire nos conseils
                        </a>
                    </div>
                </div>
            </div>
        </section>   
         <div class="max-w-7xl mx-auto my-12 px-4">
<h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Nos recommandations pour votre quotidien</h2>
<p>Chaque produit sélectionné incarne notre engagement pour un bien-être animal véritablement personnalisé. Nous
                privilégions l'esthétique, la fonctionnalité et la cohérence avec l'environnement de vie que vous partagez
                avec votre compagnon. Rien n'est laissé au hasard — chaque choix a du sens.</p>
</div>
            </div>

            <!-- Section Chiens -->
            <div>
                <h2 class="block lg:hidden text-3xl md:text-4xl font-bold text-gray-800 mb-2 px-4">Pour nos amis les chiens</h2>
                <div class="grid lg:grid-cols-2 items-center">
                    <!-- Image de chien à gauche -->
                    <div class="lg:order-1 h-full">
                        <div class="overflow-hidden shadow-lg h-full bg-gradient-to-br from-amber-400 to-orange-500">
                            <div class="h-full flex items-center justify-center">
                                <img src="{{ asset('images/dog-hero.jpg') }}" alt="Chien heureux" 
                                     class="w-full h-full object-cover hidden lg:block">
                            </div>
                        </div>
                    </div>

                    <!-- Grille de produits pour chiens à droite -->
                    <div class="lg:order-2 h-full">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 h-full p-4">
                            @forelse($dogProducts as $produit)
                                <a href="{{ route('shop.show', $produit) }}" class="h-full">
                                    <div class="bg-white shadow-md rounded-md hover:shadow-xl transition duration-300 overflow-hidden h-full flex flex-col">
                                            <div class="overflow-hidden">
                                            @if($produit->image_path)
                                                <img src="{{ asset('storage/' . $produit->image_path) }}" alt="{{ $produit->nom }}"
                                                    class="w-full object-cover h-56">
                                            @else
                                                <div class="flex items-center justify-center h-32 bg-gradient-to-br from-orange-100 to-amber-100">
                                                    <span class="text-3xl">🐕</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-3 flex-1 flex flex-col">
                                            <div class="flex justify-between mb-2 flex-1">
                                                <h4 class="text-sm font-bold text-black line-clamp-2 uppercase">{{ $produit->nom }}</h4>
                                                <span class="text-sm font-bold whitespace-nowrap text-black">{{ $produit->prix_formate }}</span>
                                            </div>
                                            @auth
                                                <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                                                    @csrf
                                                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                                    <button type="submit"
                                                        class="w-full bg-gray-800 text-white py-2 rounded-md font-semibold hover:bg-gray-700 transition duration-300 block">
                                                        Ajouter au panier
                                                    </button>
                                                </form>
                                            @endauth
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="col-span-2 text-center py-8">
                                    <p class="text-gray-500">Aucun produit pour chiens disponible.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Chats -->
            <div class="h-full">
                <h2 class="block lg:hidden text-3xl md:text-4xl font-bold text-gray-800 mb-2 px-4 mt-12 lg:mt-0">Pour nos amis les chats</h2>
                <div class="grid lg:grid-cols-2 items-center">
                    <!-- Grille de produits pour chats à gauche -->
                    <div class="h-full p-4">
                        <div class="grid grid-cols-2 gap-4 h-full">
                            @forelse($catProducts as $produit)
                                <a href="{{ route('shop.show', $produit) }}" class="h-full">
                                    <div class="bg-white shadow-md rou  nded-md hover:shadow-xl transition duration-300 overflow-hidden h-full flex flex-col">
                                        <div class="overflow-hidden">
                                            @if($produit->image_path)
                                                <img src="{{ asset('storage/' . $produit->image_path) }}" alt="{{ $produit->nom }}"
                                                    class="w-full object-cover h-56">
                                            @else
                                                <div class="flex items-center justify-center h-32 bg-gradient-to-br from-purple-100 to-pink-100">
                                                    <span class="text-3xl">🐱</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-3 flex-1 flex flex-col">
                                            <div class="flex justify-between mb-2 flex-1">
                                                <h4 class="text-sm font-bold text-black line-clamp-2 uppercase">{{ $produit->nom }}</h4>
                                                <span class="text-sm font-bold whitespace-nowrap text-black">{{ $produit->prix_formate }}</span>
                                            </div>
                                            @auth
                                                <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                                                    @csrf
                                                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                                    <button type="submit"
                                                        class="w-full bg-gray-800 text-white py-2 rounded-md font-semibold hover:bg-gray-700 transition duration-300 block">
                                                        Ajouter au panier
                                                    </button>
                                                </form>
                                            @endauth
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="col-span-2 text-center py-8">
                                    <p class="text-gray-500">Aucun produit pour chats disponible.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Image de chat à droite -->
                    <div class="h-full">
                        <div class="overflow-hidden shadow-lg h-full bg-gradient-to-br from-purple-400 to-pink-500">
                            <div class="h-full flex items-center justify-center">
                                <img src="{{ asset('images/cat-hero.jpg') }}" alt="Chat heureux" 
                                     class="w-full h-full object-cover hidden lg:block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Latest Articles -->
        <section class="py-16 bg-gray-50 max-w-7xl mx-auto px-4">
            <div class="mb-8 text-left">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Les articles du bien-être animal
                </h2>
                <p>Parce que chaque situation mérite plus qu’un conseil générique, nos articles mêlent
                    expertise, témoignages et
                    récits réels pour vous aider à voir plus clair. Ces lectures sont une invitation à prendre du recul, à
                    comprendre les enjeux cachés du quotidien avec votre animal, et à nourrir vos choix avec sens.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($latestArticles as $article)
                    <a href="{{ route('blog.show', $article) }}" class="h-full {{ $loop->last ? 'block md:hidden lg:block' : '' }}">
                        <article
                            class="bg-white rounded-md shadow-md hover:shadow-xl transition duration-300 overflow-hidden h-full flex flex-col">
                            <div class="h-48 overflow-hidden">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}" class="object-cover w-full h-full">
                                @elseif($article->banniere_article)
                                    <img src="{{ asset('storage/' . $article->banniere_article) }}" alt="{{ $article->titre }}"
                                        class="w-full h-48 object-cover">
                                @else

                                

                                    <div
                                        class="flex items-center justify-center h-48 bg-gradient-to-br from-{{ $article->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $article->categorie === 'Chien' ? 'amber' : 'pink' }}-100">
                                        <span class="text-6xl">
                                            {{ $article->categorie === 'Chien' ? '🐕' : '🐱' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center justify-between mb-3">
                                    <span
                                        class="text-xs font-medium text-{{ $article->categorie === 'Chien' ? 'orange' : 'purple' }}-600 bg-{{ $article->categorie === 'Chien' ? 'orange' : 'purple' }}-100 px-2 py-1 rounded-full">
                                        {{ $article->categorie }}
                                    </span>
                                    <time class="text-sm text-gray-500">
                                        {{ $article->created_at->format('d/m/Y') }}
                                    </time>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ $article->titre }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-1">{{ Str::limit($article->contenu, 120) }}</p>
                                <p class="inline-flex items-center text-gray-600 hover:text-gray-700 font-medium mt-auto">
                                    Lire la suite
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </p>
                            </div>
                        </article>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">Aucun article disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('blog.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-700 font-medium">
                    Voir tous les articles
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>

            </div>
        </section>
@endsection

@push('styles')
    <style>
        nav {
            position: absolute;
            top: 0;
        }

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

        .hero-banner {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ asset("images/backgrounds/hero-banner.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
@endpush