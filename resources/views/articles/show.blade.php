<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détails de l\'article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Bannière de l'article -->
                    @if($article->banniere_article)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $article->banniere_article) }}" alt="Bannière de l'article" class="w-full h-64 object-cover rounded-lg">
                        </div>
                    @endif

                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $article->titre }}</h1>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <span>Par {{ $article->utilisateur->full_name ?? 'Auteur inconnu' }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $article->date_publication->format('d/m/Y') }}</span>
                        </div>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">{{ $article->description }}</p>
                    </div>

                    <!-- Image principale -->
                    @if($article->image)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="Image de l'article" class="w-full max-w-2xl mx-auto rounded-lg">
                        </div>
                    @endif

                    <!-- Contenu -->
                    <div class="prose prose-lg max-w-none dark:prose-invert mb-8">
                        {!! nl2br(e($article->contenu)) !!}
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <p>Créé le {{ $article->created_at->format('d/m/Y H:i') }}</p>
                            <p>Modifié le {{ $article->updated_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="flex items-center space-x-2">
                            <a href="{{ route('articles.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Retour
                            </a>
                            <a href="{{ route('articles.edit', $article) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
