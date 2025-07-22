<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Produits') }}
            </h2>
            <a href="{{ route('produits.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nouveau produit
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($produits->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($produits as $produit)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="mb-4">
                                        @if($produit->image_path)
                                            <img src="{{ asset('storage/' . $produit->image_path) }}" alt="{{ $produit->nom }}" class="w-full h-48 object-cover rounded-lg">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                                <span class="text-gray-500">Pas d'image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-semibold mb-2">{{ $produit->nom }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-2">{{ Str::limit($produit->description, 100) }}</p>
                                    
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="text-green-600 font-bold">{{ number_format($produit->prix_euros, 2) }} €</p>
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ $produit->categorie }}</span>
                                    </div>
                                    
                                    <div class="flex space-x-2 mt-4">
                                        <a href="{{ route('produits.show', $produit) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Voir
                                        </a>
                                        <a href="{{ route('produits.edit', $produit) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Modifier
                                        </a>
                                        <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $produits->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600 dark:text-gray-400">Aucun produit trouvé.</p>
                            <a href="{{ route('produits.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Créer le premier produit
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
