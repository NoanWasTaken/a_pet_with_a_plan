<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $produit->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            @if($produit->image_path)
                                <img src="{{ asset('storage/' . $produit->image_path) }}" alt="{{ $produit->nom }}" class="w-full h-96 object-cover rounded-lg">
                            @else
                                <div class="w-full h-96 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">Pas d'image</span>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <h1 class="text-3xl font-bold mb-4">{{ $produit->nom }}</h1>
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-2xl text-green-600 font-bold">{{ number_format($produit->prix_euros, 2) }} €</p>
                                <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full dark:bg-blue-200 dark:text-blue-800">{{ $produit->categorie }}</span>
                            </div>
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Description</h3>
                                <p class="text-gray-600 dark:text-gray-400">{{ $produit->description }}</p>
                            </div>

                            @if($produit->notes->count() > 0)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-2">Évaluations</h3>
                                    <div class="flex items-center mb-2">
                                        <span class="text-yellow-500 mr-2">★</span>
                                        <span class="font-semibold">{{ number_format($produit->notes->avg('note'), 1) }}/5</span>
                                        <span class="text-gray-500 ml-2">({{ $produit->notes->count() }} avis)</span>
                                    </div>
                                </div>
                            @endif

                            <div class="flex space-x-2">
                                <a href="{{ route('produits.edit', $produit) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Modifier
                                </a>
                                <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($produit->notes->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold mb-4">Avis des utilisateurs</h3>
                            <div class="space-y-4">
                                @foreach($produit->notes as $note)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="font-semibold">{{ $note->utilisateur->full_name ?? 'Utilisateur inconnu' }}</span>
                                            <span class="text-yellow-500 ml-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $note->note ? '★' : '☆' }}
                                                @endfor
                                            </span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $note->commentaire }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
