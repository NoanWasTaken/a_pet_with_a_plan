@extends('layouts.public')

@section('title', 'Mon profil - A Pet with a Plan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Mon profil</h1>
                <p class="text-gray-600">Gérez vos informations personnelles et vos préférences</p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Menu de navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
                        </div>
                        <nav class="p-4">
                            <ul class="space-y-2">
                                <li>
                                    <a href="#informations" 
                                       class="profile-tab flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition duration-300 active">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Informations personnelles
                                    </a>
                                </li>
                                <li>
                                    <a href="#mot-de-passe" 
                                       class="profile-tab flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition duration-300">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        Mot de passe
                                    </a>
                                </li>
                                <li>
                                    <a href="#preferences" 
                                       class="profile-tab flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition duration-300">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Préférences
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="lg:col-span-2">
                    <!-- Informations personnelles -->
                    <div id="informations-content" class="profile-content bg-white rounded-lg shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Informations personnelles</h2>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                        <input type="text" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', auth()->user()->name) }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                                               required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', auth()->user()->email) }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                                               required>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone (optionnel)</label>
                                    <input type="tel" 
                                           id="telephone" 
                                           name="telephone" 
                                           value="{{ old('telephone', auth()->user()->telephone ?? '') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('telephone') border-red-500 @enderror">
                                    @error('telephone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mt-6">
                                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">Adresse (optionnel)</label>
                                    <textarea id="adresse" 
                                              name="adresse" 
                                              rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('adresse') border-red-500 @enderror">{{ old('adresse', auth()->user()->adresse ?? '') }}</textarea>
                                    @error('adresse')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mt-8 flex justify-end">
                                    <button type="submit" 
                                            class="bg-gray-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-700 transition duration-300">
                                        Sauvegarder
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Changement de mot de passe -->
                    <div id="mot-de-passe-content" class="profile-content bg-white rounded-lg shadow-md hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Changer mon mot de passe</h2>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="space-y-6">
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                                        <input type="password" 
                                               id="current_password" 
                                               name="current_password" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('current_password') border-red-500 @enderror" 
                                               required>
                                        @error('current_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                                        <input type="password" 
                                               id="password" 
                                               name="password" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('password') border-red-500 @enderror" 
                                               required>
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                                        <input type="password" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent" 
                                               required>
                                    </div>
                                </div>
                                
                                <div class="mt-8 flex justify-end">
                                    <button type="submit" 
                                            class="bg-gray-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-700 transition duration-300">
                                        Changer le mot de passe
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Préférences -->
                    <div id="preferences-content" class="profile-content bg-white rounded-lg shadow-md hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Mes préférences</h2>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('profile.preferences') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-700 mb-3">Animal de compagnie préféré</h3>
                                        <div class="space-y-2">
                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="animal_prefere" 
                                                       value="Chien" 
                                                       class="mr-3 text-gray-600 focus:ring-gray-500"
                                                       {{ (old('animal_prefere', auth()->user()->animal_prefere ?? '') === 'Chien') ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">🐕 Chien</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="animal_prefere" 
                                                       value="Chat" 
                                                       class="mr-3 text-gray-600 focus:ring-gray-500"
                                                       {{ (old('animal_prefere', auth()->user()->animal_prefere ?? '') === 'Chat') ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">🐱 Chat</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="animal_prefere" 
                                                       value="" 
                                                       class="mr-3 text-gray-600 focus:ring-gray-500"
                                                       {{ (old('animal_prefere', auth()->user()->animal_prefere ?? '') === '') ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">Aucune préférence</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-700 mb-3">Notifications par email</h3>
                                        <div class="space-y-2">
                                            <label class="flex items-center">
                                                <input type="checkbox" 
                                                       name="newsletter" 
                                                       value="1" 
                                                       class="mr-3 text-gray-600 focus:ring-gray-500"
                                                       {{ old('newsletter', auth()->user()->newsletter ?? false) ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">Newsletter et nouveautés</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" 
                                                       name="promotions" 
                                                       value="1" 
                                                       class="mr-3 text-gray-600 focus:ring-gray-500"
                                                       {{ old('promotions', auth()->user()->promotions ?? false) ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">Offres promotionnelles</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-700 mb-3">Devise préférée</h3>
                                        <div class="space-y-2">
                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="devise_preferee" 
                                                       value="EUR" 
                                                       class="mr-3 text-gray-600 focus:ring-gray-500"
                                                       {{ (old('devise_preferee', auth()->user()->devise_preferee ?? 'EUR') === 'EUR') ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">€ Euro (EUR)</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="devise_preferee" 
                                                       value="USD" 
                                                       class="mr-3 text-gray-600 focus:ring-gray-500"
                                                       {{ (old('devise_preferee', auth()->user()->devise_preferee ?? '') === 'USD') ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">$ Dollar US (USD)</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="devise_preferee" 
                                                       value="GBP" 
                                                       class="mr-3 text-gray-600 focus:ring-gray-500"
                                                       {{ (old('devise_preferee', auth()->user()->devise_preferee ?? '') === 'GBP') ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">£ Livre Sterling (GBP)</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="devise_preferee" 
                                                       value="CAD" 
                                                       class="mr-3 text-gray-600 focus:ring-gray-500"
                                                       {{ (old('devise_preferee', auth()->user()->devise_preferee ?? '') === 'CAD') ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">C$ Dollar Canadien (CAD)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-8 flex justify-end">
                                    <button type="submit" 
                                            class="bg-gray-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-700 transition duration-300">
                                        Sauvegarder
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets du profil
    const tabs = document.querySelectorAll('.profile-tab');
    const contents = document.querySelectorAll('.profile-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Supprimer la classe active de tous les onglets
            tabs.forEach(t => t.classList.remove('active', 'bg-gray-100', 'text-gray-700'));
            tabs.forEach(t => t.classList.add('text-gray-700'));
            
            // Ajouter la classe active à l'onglet cliqué
            this.classList.add('active', 'bg-gray-100', 'text-gray-700');
            this.classList.remove('text-gray-700');
            
            // Masquer tous les contenus
            contents.forEach(content => content.classList.add('hidden'));
            
            // Afficher le contenu correspondant
            const target = this.getAttribute('href').substring(1);
            const targetContent = document.getElementById(target + '-content');
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });
});
</script>
@endpush
