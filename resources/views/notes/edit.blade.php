<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier la note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('notes.update', $note) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="id_utilisateur" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Utilisateur</label>
                            <select name="id_utilisateur" id="id_utilisateur" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Choisir un utilisateur</option>
                                @foreach($utilisateurs as $utilisateur)
                                    <option value="{{ $utilisateur->id }}" {{ old('id_utilisateur', $note->id_utilisateur) == $utilisateur->id ? 'selected' : '' }}>
                                        {{ $utilisateur->prenom }} {{ $utilisateur->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_utilisateur')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="id_produit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produit</label>
                            <select name="id_produit" id="id_produit" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Choisir un produit</option>
                                @foreach($produits as $produit)
                                    <option value="{{ $produit->id }}" {{ old('id_produit', $note->id_produit) == $produit->id ? 'selected' : '' }}>
                                        {{ $produit->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_produit')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Note (1 à 5)</label>
                            <select name="note" id="note" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Choisir une note</option>
                                <option value="1" {{ old('note', $note->note) == '1' ? 'selected' : '' }}>1 étoile</option>
                                <option value="2" {{ old('note', $note->note) == '2' ? 'selected' : '' }}>2 étoiles</option>
                                <option value="3" {{ old('note', $note->note) == '3' ? 'selected' : '' }}>3 étoiles</option>
                                <option value="4" {{ old('note', $note->note) == '4' ? 'selected' : '' }}>4 étoiles</option>
                                <option value="5" {{ old('note', $note->note) == '5' ? 'selected' : '' }}>5 étoiles</option>
                            </select>
                            @error('note')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="commentaire" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Commentaire</label>
                            <textarea name="commentaire" id="commentaire" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('commentaire', $note->commentaire) }}</textarea>
                            @error('commentaire')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('notes.show', $note) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
