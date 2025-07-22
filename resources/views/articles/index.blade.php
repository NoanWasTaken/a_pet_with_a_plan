<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Articles') }}
            </h2>
            <a href="{{ route('articles.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nouvel article
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($articles->count() > 0)
                        <div class="space-y-6">
                            @foreach($articles as $article)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-semibold mb-2">{{ $article->titre }}</h3>
                                            <p class="text-gray-600 dark:text-gray-400 mb-2">{{ Str::limit($article->description, 150) }}</p>
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                                                <span>Par {{ $article->utilisateur->full_name ?? 'Auteur inconnu' }}</span>
                                                <span class="mx-2">•</span>
                                                <span>{{ $article->date_publication->format('d/m/Y') }}</span>
                                                <span class="mx-2">•</span>
                                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ $article->categorie }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <img src="{{ asset('storage/' . $article->banniere_article) }}" alt="{{ $article->titre }}" class="w-32 h-20 object-cover rounded">
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('articles.show', $article) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Voir
                                        </a>
                                        <a href="{{ route('articles.edit', $article) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Modifier
                                        </a>
                                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $articles->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600 dark:text-gray-400">Aucun article trouvé.</p>
                            <a href="{{ route('articles.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Créer le premier article
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
