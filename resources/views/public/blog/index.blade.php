@extends('layouts.public')

@section('title', 'Blog - A Pet with a Plan')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <section class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-6 lg:mb-0">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Notre Blog</h1>
                        <p class="text-gray-600">Conseils, astuces et actualités pour le bien-être de vos animaux</p>
                    </div>

                    <!-- Filtres et recherche -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <form method="GET" action="{{ route('blog.index') }}" class="flex flex-col sm:flex-row gap-4">
                            <!-- Recherche -->
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Rechercher un article..."
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
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Plus récent
                                </option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Plus ancien
                                </option>
                                <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Titre A-Z
                                </option>
                                <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>Titre Z-A
                                </option>
                            </select>

                            <button type="submit"
                                class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                                Filtrer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Résultats -->
        <section class="py-8">
            <div class="container mx-auto px-4">
                <!-- Info résultats -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                    <p class="text-gray-600 mb-4 sm:mb-0">
                        {{ $articles->total() }} article{{ $articles->total() > 1 ? 's' : '' }}
                        trouvé{{ $articles->total() > 1 ? 's' : '' }}
                    </p>

                    @if(request()->hasAny(['search', 'categorie', 'sort']))
                        <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-gray-700 underline">
                            Effacer les filtres
                        </a>
                    @endif
                </div>

                <!-- Articles en vedette (premier article) -->
                @if($articles->count() > 0 && !request()->hasAny(['search', 'categorie', 'sort']))
                    @php $featuredArticle = $articles->first(); @endphp
                    <div class="mb-12">
                        <a href="{{ route('blog.show', $featuredArticle) }}">
                            <article
                                class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                                <div class="grid grid-cols-1 lg:grid-cols-2">
                                    <div class="overflow-hidden">
                                        @if($featuredArticle->image)
                                            <img src="{{ asset('storage/' . $featuredArticle->image) }}"
                                                alt="{{ $featuredArticle->titre }}" class="object-cover w-full h-full min-h-64">
                                        @elseif($featuredArticle->banniere_article)
                                            <img src="{{ asset('storage/' . $featuredArticle->banniere_article) }}"
                                                alt="{{ $featuredArticle->titre }}" class="object-cover w-full h-full min-h-64">
                                        @else
                                            <div
                                                class="bg-gradient-to-br from-{{ $featuredArticle->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $featuredArticle->categorie === 'Chien' ? 'amber' : 'pink' }}-100">
                                                <div class="flex items-center justify-center h-full min-h-64">
                                                    <span class="text-9xl">
                                                        {{ $featuredArticle->categorie === 'Chien' ? '🐕' : '🐱' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-8 flex flex-col justify-center">
                                        <div class="flex items-center gap-4 mb-4">
                                            <span
                                                class="text-sm font-medium text-{{ $featuredArticle->categorie === 'Chien' ? 'orange' : 'purple' }}-600 bg-{{ $featuredArticle->categorie === 'Chien' ? 'orange' : 'purple' }}-100 px-3 py-1 rounded-full">
                                                {{ $featuredArticle->categorie }}
                                            </span>
                                            <time class="text-sm text-gray-500">
                                                {{ $featuredArticle->created_at->format('d/m/Y') }}
                                            </time>
                                        </div>
                                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
                                            {{ $featuredArticle->titre }}
                                        </h2>
                                        <p class="text-gray-600 mb-6 line-clamp-4">
                                            {{ Str::limit($featuredArticle->contenu, 200) }}
                                        </p>
                                        <p class="inline-flex items-center text-gray-600 hover:text-gray-700 font-semibold">
                                            Lire l'article complet
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </p>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                @endif

                <!-- Grille d'articles -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($articles->skip(1) as $article)
                        <a href="{{ route('blog.show', $article) }}">


                            <article
                                class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                                <div class="overflow-hidden">
                                    @if($article->image)
                                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}"
                                            class="object-cover w-full h-48">
                                    @elseif($article->banniere_article)
                                        <img src="{{ asset('storage/' . $article->banniere_article) }}" alt="{{ $article->titre }}"
                                            class="object-cover w-full h-48">
                                    @else
                                        <div
                                            class="bg-gradient-to-br from-{{ $article->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $article->categorie === 'Chien' ? 'amber' : 'pink' }}-100">
                                            <div class="flex items-center justify-center h-48">
                                                <span class="text-6xl">
                                                    {{ $article->categorie === 'Chien' ? '🐕' : '🐱' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <span
                                            class="text-xs font-medium text-{{ $article->categorie === 'Chien' ? 'orange' : 'purple' }}-600 bg-{{ $article->categorie === 'Chien' ? 'orange' : 'purple' }}-100 px-2 py-1 rounded-full">
                                            {{ $article->categorie }}
                                        </span>
                                        <time class="text-sm text-gray-500">
                                            {{ $article->created_at->format('d/m/Y') }}
                                        </time>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3 line-clamp-2">{{ $article->titre }}</h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($article->contenu, 120) }}
                                    </p>
                                    <p class="inline-flex items-center text-gray-600 hover:text-gray-700 font-medium">
                                        Lire la suite
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </p>
                                </div>
                            </article>
                        </a>
                    @empty
                        @if($articles->count() === 0)
                            <div class="col-span-full text-center py-16">
                                <div class="text-6xl mb-4">📝</div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun article trouvé</h3>
                                <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche.</p>
                                <a href="{{ route('blog.index') }}"
                                    class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-300">
                                    Voir tous les articles
                                </a>
                            </div>
                        @endif
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="mt-12">
                        {{ $articles->appends(request()->query())->links() }}
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

        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush