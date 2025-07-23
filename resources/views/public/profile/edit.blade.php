@extends('layouts.public')

@section('title', 'Mon Profil - A Pet with a Plan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Mon Profil</h1>
            <p class="text-gray-600">Gérez vos informations personnelles et préférences</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Navigation des onglets -->
            <div class="lg:col-span-1">
                <nav class="bg-white rounded-lg shadow-sm p-6">
                    <ul class="space-y-2">
                        <li>
                            <a href="#informations" class="flex items-center px-3 py-2 text-gray-600 bg-gray-50 rounded-md text-sm font-medium">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informations personnelles
                            </a>
                        </li>
                        <li>
                            <a href="#mot-de-passe" class="flex items-center px-3 py-2 text-gray-700 hover:text-gray-600 hover:bg-gray-50 rounded-md text-sm font-medium">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Mot de passe
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}" class="flex items-center px-3 py-2 text-gray-700 hover:text-gray-600 hover:bg-gray-50 rounded-md text-sm font-medium">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Mes commandes
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Contenu principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations personnelles -->
                <div id="informations" class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Informations personnelles</h2>
                    
                    @if (session('status') === 'profile-updated')
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg">
                            Profil mis à jour avec succès.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Prénom -->
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                                <input type="text" 
                                       id="prenom" 
                                       name="prenom" 
                                       value="{{ old('prenom', $user->prenom) }}" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                @error('prenom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                <input type="text" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom', $user->nom) }}" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                @error('nom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2 text-sm text-yellow-600">
                                    Votre adresse email n'est pas vérifiée.
                                    <a href="{{ route('verification.send') }}" class="underline hover:text-yellow-700">
                                        Renvoyer l'email de vérification
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Devise préférée -->
                        <div>
                            <label for="devise_preferee" class="block text-sm font-medium text-gray-700 mb-2">Devise préférée</label>
                            <select id="devise_preferee" 
                                    name="devise_preferee" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                <option value="EUR" {{ old('devise_preferee', $user->devise_preferee) === 'EUR' ? 'selected' : '' }}>Euro (€)</option>
                                <option value="USD" {{ old('devise_preferee', $user->devise_preferee) === 'USD' ? 'selected' : '' }}>Dollar US ($)</option>
                                <option value="GBP" {{ old('devise_preferee', $user->devise_preferee) === 'GBP' ? 'selected' : '' }}>Livre Sterling (£)</option>
                                <option value="CAD" {{ old('devise_preferee', $user->devise_preferee) === 'CAD' ? 'selected' : '' }}>Dollar Canadien (C$)</option>
                            </select>
                            @error('devise_preferee')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Préférences d'animaux -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Mes animaux de compagnie</label>
                            <p class="text-sm text-gray-500 mb-4">Sélectionnez vos animaux pour personnaliser vos recommandations dans la boutique</p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Chiens -->
                                <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <input type="hidden" name="aime_chiens" value="0">
                                    <input type="checkbox" 
                                           id="aime_chiens" 
                                           name="aime_chiens" 
                                           value="1"
                                           {{ old('aime_chiens', $user->aime_chiens) ? 'checked' : '' }}
                                           class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                    <label for="aime_chiens" class="ml-3 flex items-center cursor-pointer">
                                        <span class="text-2xl mr-2">🐕</span>
                                        <div>
                                            <div class="text-sm font-medium text-gray-700">J'ai un chien</div>
                                            <div class="text-xs text-gray-500">Produits pour chiens</div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Chats -->
                                <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <input type="hidden" name="aime_chats" value="0">
                                    <input type="checkbox" 
                                           id="aime_chats" 
                                           name="aime_chats" 
                                           value="1"
                                           {{ old('aime_chats', $user->aime_chats) ? 'checked' : '' }}
                                           class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 focus:ring-2">
                                    <label for="aime_chats" class="ml-3 flex items-center cursor-pointer">
                                        <span class="text-2xl mr-2">🐱</span>
                                        <div>
                                            <div class="text-sm font-medium text-gray-700">J'ai un chat</div>
                                            <div class="text-xs text-gray-500">Produits pour chats</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            @error('aime_chiens')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('aime_chats')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Changement de mot de passe -->
                <div id="mot-de-passe" class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Changer le mot de passe</h2>

                    @if (session('status') === 'password-updated')
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg">
                            Mot de passe mis à jour avec succès.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <!-- Mot de passe actuel -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            @error('current_password', 'updatePassword')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nouveau mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            @error('password', 'updatePassword')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation du nouveau mot de passe -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            @error('password_confirmation', 'updatePassword')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                                Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
