<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détails de la question FAQ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Question</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-900 dark:text-gray-100">{{ $question->question }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Réponse</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="prose prose-sm max-w-none dark:prose-invert">
                                {!! nl2br(e($question->reponse)) !!}
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <p>Créé le {{ $question->created_at->format('d/m/Y H:i') }}</p>
                            <p>Modifié le {{ $question->updated_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('questions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Retour
                            </a>
                            <a href="{{ route('questions.edit', $question) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
