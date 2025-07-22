@extends('layouts.public')

@section('title', $article->titre . ' - Blog - A Pet with a Plan')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb -->
        <nav class="bg-white border-b">
            <div class="container mx-auto px-4 py-4">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-700">Accueil</a></li>
                    <li class="text-gray-500">/</li>
                    <li><a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-gray-700">Blog</a></li>
                    <li class="text-gray-500">/</li>
                    <li class="text-gray-700">{{ Str::limit($article->titre, 50) }}</li>
                </ol>
            </div>
        </nav>

        <article class="container mx-auto px-4 py-8">
            <!-- En-tête de l'article -->
            <header class="max-w-4xl mx-auto mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <span
                        class="text-sm font-medium text-{{ $article->categorie === 'Chien' ? 'orange' : 'purple' }}-600 bg-{{ $article->categorie === 'Chien' ? 'orange' : 'purple' }}-100 px-3 py-1 rounded-full">
                        {{ $article->categorie }}
                    </span>
                    <time class="text-sm text-gray-500">
                        Publié le {{ $article->created_at->format('d/m/Y') }}
                    </time>
                    @if($article->updated_at != $article->created_at)
                        <time class="text-sm text-gray-500">
                            (Mis à jour le {{ $article->updated_at->format('d/m/Y') }})
                        </time>
                    @endif
                </div>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-6 leading-tight">
                    {{ $article->titre }}
                </h1>

                <!-- Image principale -->
                <div class="overflow-hidden rounded-xl shadow-lg mb-8">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->titre }}"
                            class="object-cover w-full h-64">
                    @elseif($article->banniere_article)
                        <img src="{{ asset('storage/' . $article->banniere_article) }}" alt="{{ $article->titre }}"
                            class="object-cover w-full h-64">
                    @else
                        <div
                            class="bg-gradient-to-br from-{{ $article->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $article->categorie === 'Chien' ? 'amber' : 'pink' }}-100">
                            <div class="flex items-center justify-center h-64">
                                <span class="text-9xl">
                                    {{ $article->categorie === 'Chien' ? '🐕' : '🐱' }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </header>

            <!-- Contenu de l'article -->
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Contenu principal -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-lg shadow-sm p-8">
                            <div class="prose prose-lg prose-gray max-w-none">
                                {!! nl2br(e($article->contenu)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Partage -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Partager</h3>
                            <div class="flex flex-col space-y-3">
                                <a href="#"
                                    onclick="window.open('https://twitter.com/intent/tweet?text={{ urlencode($article->titre) }}&url={{ urlencode(route('blog.show', $article)) }}', '_blank', 'width=600,height=400')"
                                    class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                    </svg>
                                    Twitter
                                </a>

                                <a href="#"
                                    onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $article)) }}', '_blank', 'width=600,height=400')"
                                    class="flex items-center px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                    Facebook
                                </a>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Navigation</h3>
                            <div class="space-y-3">
                                <a href="{{ route('blog.index', ['categorie' => $article->categorie]) }}"
                                    class="block text-gray-600 hover:text-gray-700 hover:underline">
                                    ← Autres articles {{ $article->categorie }}
                                </a>
                                <a href="{{ route('shop.index', ['categorie' => $article->categorie]) }}"
                                    class="block text-gray-600 hover:text-gray-700 hover:underline">
                                    Produits pour {{ $article->categorie === 'Chien' ? 'chiens' : 'chats' }} →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles similaires -->
            @if($relatedArticles->count() > 0)
                <div class="max-w-6xl mx-auto mt-16">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8">Articles similaires</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('blog.show', $related) }}">
                                <article
                                    class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                                    <div class="overflow-hidden">
                                        @if($related->image)
                                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->titre }}"
                                                class="object-cover w-full h-48">
                                        @elseif($related->banniere_article)
                                            <img src="{{ asset('storage/' . $related->banniere_article) }}" alt="{{ $related->titre }}"
                                                class="object-cover w-full h-48">
                                        @else
                                            <div
                                                class="bg-gradient-to-br from-{{ $related->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $related->categorie === 'Chien' ? 'amber' : 'pink' }}-100">
                                                <div class="flex items-center justify-center h-48">
                                                    <span class="text-6xl">
                                                        {{ $related->categorie === 'Chien' ? '🐕' : '🐱' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-3">
                                            <span
                                                class="text-xs font-medium text-{{ $related->categorie === 'Chien' ? 'orange' : 'purple' }}-600 bg-{{ $related->categorie === 'Chien' ? 'orange' : 'purple' }}-100 px-2 py-1 rounded-full">
                                                {{ $related->categorie }}
                                            </span>
                                            <time class="text-sm text-gray-500">
                                                {{ $related->created_at->format('d/m/Y') }}
                                            </time>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-3 line-clamp-2">{{ $related->titre }}</h3>
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($related->contenu, 120) }}
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
                        @endforeach
                    </div>
                </div>
            @endif
        </article>
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

        .prose {
            color: #374151;
            line-height: 1.75;
        }

        .prose p {
            margin-bottom: 1.25em;
        }

        .prose h2 {
            font-size: 1.5em;
            font-weight: 700;
            margin-top: 2em;
            margin-bottom: 1em;
            color: #1f2937;
        }

        .prose h3 {
            font-size: 1.25em;
            font-weight: 600;
            margin-top: 1.6em;
            margin-bottom: 0.6em;
            color: #1f2937;
        }

        .prose strong {
            font-weight: 600;
            color: #1f2937;
        }

        .prose ul,
        .prose ol {
            margin-top: 1.25em;
            margin-bottom: 1.25em;
            padding-left: 1.625em;
        }

        .prose li {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }
    </style>
@endpush