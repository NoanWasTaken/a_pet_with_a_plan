<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('FAQ - Questions fréquentes') }}
            </h2>
            <a href="{{ route('questions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nouvelle question
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($questions->count() > 0)
                        <div class="space-y-4">
                            @foreach($questions as $question)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold mb-2">{{ $question->question }}</h3>
                                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($question->reponse, 200) }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('questions.show', $question) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Voir
                                        </a>
                                        <a href="{{ route('questions.edit', $question) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Modifier
                                        </a>
                                        <form action="{{ route('questions.destroy', $question) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $questions->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600 dark:text-gray-400">Aucune question trouvée.</p>
                            <a href="{{ route('questions.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Créer la première question
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
