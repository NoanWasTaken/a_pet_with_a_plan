<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Créer une nouvelle commande') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('commandes.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="id_utilisateur" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Utilisateur</label>
                            <select name="id_utilisateur" id="id_utilisateur" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Choisir un utilisateur</option>
                                @foreach($utilisateurs as $utilisateur)
                                    <option value="{{ $utilisateur->id }}" {{ old('id_utilisateur') == $utilisateur->id ? 'selected' : '' }}>
                                        {{ $utilisateur->prenom }} {{ $utilisateur->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_utilisateur')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date_commande" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de commande</label>
                            <input type="date" name="date_commande" id="date_commande" value="{{ old('date_commande', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('date_commande')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Produits</label>
                            
                            <div id="produits-container">
                                <div class="produit-item border dark:border-gray-600 p-4 rounded mb-3">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produit</label>
                                            <select name="produits[0][id]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                <option value="">Choisir un produit</option>
                                                @foreach($produits as $produit)
                                                    <option value="{{ $produit->id }}">
                                                        {{ $produit->nom }} ({{ number_format($produit->prix_euros, 2) }}€)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantité</label>
                                            <input type="number" name="produits[0][quantite]" value="1" min="1" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" class="remove-produit bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm" style="display:none;">
                                                Retirer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" id="add-produit" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                + Ajouter un produit
                            </button>
                            
                            @error('produits')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('commandes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Créer la commande
                            </button>
                        </div>
                    </form>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let produitsContainer = document.getElementById('produits-container');
                            let addButton = document.getElementById('add-produit');
                            let produitIndex = 0;
                            
                            addButton.addEventListener('click', function() {
                                produitIndex++;
                                
                                let template = document.querySelector('.produit-item').cloneNode(true);
                                let selects = template.querySelectorAll('select');
                                let inputs = template.querySelectorAll('input');
                                let removeButton = template.querySelector('.remove-produit');
                                
                                // Update names
                                selects.forEach(select => {
                                    select.name = select.name.replace('[0]', `[${produitIndex}]`);
                                    select.value = '';
                                });
                                
                                inputs.forEach(input => {
                                    input.name = input.name.replace('[0]', `[${produitIndex}]`);
                                    input.value = '1';
                                });
                                
                                // Show remove button
                                removeButton.style.display = 'block';
                                removeButton.addEventListener('click', function() {
                                    template.remove();
                                });
                                
                                produitsContainer.appendChild(template);
                            });
                            
                            // Setup the first item's remove button
                            document.querySelectorAll('.remove-produit').forEach(button => {
                                if (document.querySelectorAll('.produit-item').length > 1) {
                                    button.style.display = 'block';
                                    button.addEventListener('click', function() {
                                        button.closest('.produit-item').remove();
                                    });
                                }
                            });
                        });
                    </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
