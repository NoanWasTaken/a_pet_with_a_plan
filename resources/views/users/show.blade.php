<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détails de l\'utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informations de l'utilisateur</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->nom }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prénom</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->prenom }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->statut == 'admin' ? 'bg-red-100 text-red-800' : 
                                       ($user->statut == 'moderateur' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($user->statut) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de création</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dernière modification</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Historique des commandes -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Historique des commandes</h3>
                        
                        @if($user->commandes->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Commande #</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produits</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantité totale</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Montant</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach($user->commandes->sortByDesc('date_commande') as $commande)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    #{{ $commande->id }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $commande->date_commande->format('d/m/Y') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                    @if($commande->produits->count() > 0)
                                                        <div class="max-w-xs">
                                                            @foreach($commande->produits->take(3) as $produit)
                                                                <div class="truncate">• {{ $produit->nom }}</div>
                                                            @endforeach
                                                            @if($commande->produits->count() > 3)
                                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                    et {{ $commande->produits->count() - 3 }} autre(s)...
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-gray-500 dark:text-gray-400">Aucun produit</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $commande->produits->sum('pivot.quantite') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ number_format($commande->prix_total, 2) }}€
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('commandes.show', $commande->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        Voir détails
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Total des commandes :</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ $user->commandes->count() }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Montant total dépensé :</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ number_format($user->commandes->sum('prix_total'), 2) }}€</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Dernière commande :</span>
                                        <span class="text-gray-900 dark:text-gray-100">
                                            @if($user->commandes->count() > 0)
                                                {{ $user->commandes->sortByDesc('date_commande')->first()->date_commande->format('d/m/Y') }}
                                            @else
                                                Aucune
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-500 dark:text-gray-400 mb-4">
                                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400">Cet utilisateur n'a encore passé aucune commande.</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-2">
                        <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Retour
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Modifier
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
