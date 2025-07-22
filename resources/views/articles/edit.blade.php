<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier l\'article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                            <input type="text" name="titre" id="titre" value="{{ old('titre', $article->titre) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('titre')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description', $article->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="contenu" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contenu</label>
                            <textarea name="contenu" id="contenu" rows="8" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('contenu', $article->contenu) }}</textarea>
                            @error('contenu')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image (laisser vide pour ne pas changer)</label>
                            @if($article->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="Image actuelle" class="w-32 h-32 object-cover rounded">
                                </div>
                            @endif
                            <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('image')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="banniere_article" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bannière de l'article (laisser vide pour ne pas changer)</label>
                            @if($article->banniere_article)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $article->banniere_article) }}" alt="Bannière actuelle" class="w-64 h-32 object-cover rounded">
                                </div>
                            @endif
                            <input type="file" name="banniere_article" id="banniere_article" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('banniere_article')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date_publication" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de publication</label>
                            <input type="date" name="date_publication" id="date_publication" value="{{ old('date_publication', $article->date_publication->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('date_publication')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="id_utilisateur" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auteur</label>
                            <select name="id_utilisateur" id="id_utilisateur" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Choisir un auteur</option>
                                @foreach($utilisateurs as $utilisateur)
                                    <option value="{{ $utilisateur->id }}" {{ old('id_utilisateur', $article->id_utilisateur) == $utilisateur->id ? 'selected' : '' }}>
                                        {{ $utilisateur->prenom }} {{ $utilisateur->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_utilisateur')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="categorie" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catégorie</label>
                            <select name="categorie" id="categorie" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Sélectionner une catégorie</option>
                                <option value="Chien" {{ old('categorie', $article->categorie) == 'Chien' ? 'selected' : '' }}>Chien</option>
                                <option value="Chat" {{ old('categorie', $article->categorie) == 'Chat' ? 'selected' : '' }}>Chat</option>
                            </select>
                            @error('categorie')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('articles.show', $article) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
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
