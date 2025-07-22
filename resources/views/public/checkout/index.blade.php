@extends('layouts.public')

@section('title', 'Commande - A Pet with a Plan')

@section('content')
<div class="bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Finaliser ma commande</h1>
                <p class="text-gray-600">Vérifiez vos informations et procédez au paiement</p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 py-6">
        <div class="max-w-6xl mx-auto">
            @if($cart && $cart->items->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Informations de commande -->
                    <div class="space-y-6">
                        <!-- Adresse de livraison -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Adresse de livraison</h2>
                            <form id="checkout-form">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                                        <input type="text" id="prenom" name="prenom" 
                                               value="{{ auth()->user()->prenom ?? '' }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                               required>
                                    </div>
                                    <div>
                                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                        <input type="text" id="nom" name="nom" 
                                               value="{{ auth()->user()->nom ?? '' }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                               required>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" id="email" name="email" 
                                           value="{{ auth()->user()->email ?? '' }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                           required>
                                </div>
                                
                                <div class="mt-4">
                                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                    <input type="text" id="adresse" name="adresse" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                           required>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="code_postal" class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                                        <input type="text" id="code_postal" name="code_postal" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                               required>
                                    </div>
                                    <div>
                                        <label for="ville" class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                        <input type="text" id="ville" name="ville" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                               required>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Paiement -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">💳 Paiement sécurisé</h2>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <div class="text-blue-500 mr-3">🔒</div>
                                    <div>
                                        <p class="text-sm text-blue-800 font-medium">Paiement sécurisé avec Stripe</p>
                                        <p class="text-xs text-blue-600">Vos données bancaires sont protégées</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <!-- Bouton de paiement -->
                                <button type="button" 
                                        id="submit-payment" 
                                        class="w-full bg-purple-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span id="button-text">Procéder au paiement</span>
                                    <span id="spinner" class="hidden">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Traitement...
                                    </span>
                                </button>
                                
                                <div id="payment-errors" role="alert" class="text-red-600 text-sm hidden"></div>
                                
                                <p class="text-xs text-gray-500 text-center">
                                    En procédant au paiement, vous acceptez nos conditions générales de vente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Résumé de commande -->
                    <div>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-8">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-800">Résumé de commande</h2>
                            </div>
                            
                            <div class="p-6">
                                <!-- Articles -->
                                <div class="space-y-4 mb-6">
                                    @foreach($cart->items as $item)
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-gradient-to-br from-{{ $item->produit->categorie === 'Chien' ? 'orange' : 'purple' }}-100 to-{{ $item->produit->categorie === 'Chien' ? 'orange' : 'purple' }}-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <span class="text-lg">
                                                    {{ $item->produit->categorie === 'Chien' ? '🐕' : '🐱' }}
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-800 truncate">{{ $item->produit->nom }}</h4>
                                                <p class="text-xs text-gray-500">{{ $item->produit->categorie }} × {{ $item->quantity }}</p>
                                            </div>
                                            <div class="text-sm font-medium text-gray-800">
                                                {{ $item->total_formate }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Totaux -->
                                <div class="space-y-2 border-t pt-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Sous-total ({{ $cart->total_items }} article{{ $cart->total_items > 1 ? 's' : '' }})</span>
                                        <span class="font-medium">{{ $cart->total_formate }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Livraison</span>
                                        <span class="font-medium text-green-600">Gratuite</span>
                                    </div>
                                    
                                    <div class="flex justify-between text-lg font-semibold border-t pt-2">
                                        <span class="text-gray-800">Total</span>
                                        <span class="text-green-600">{{ $cart->total_formate }}</span>
                                    </div>
                                </div>
                                
                                <!-- Bouton de paiement sera ajouté ici par JavaScript si nécessaire -->
                                <div id="payment-button-container"></div>
                                
                                <p class="text-xs text-gray-500 text-center mt-3">
                                    En procédant au paiement, vous acceptez nos conditions générales de vente.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Panier vide -->
                <div class="max-w-md mx-auto text-center py-16">
                    <div class="text-6xl mb-6">🛒</div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Votre panier est vide</h2>
                    <p class="text-gray-600 mb-8">Ajoutez des produits à votre panier pour procéder au checkout.</p>
                    <a href="{{ route('shop.index') }}" 
                       class="bg-purple-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-purple-700 transition duration-300">
                        Voir la boutique
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration Stripe
    const stripeKey = '{{ config("stripe.publishable_key") }}';
    
    if (!stripeKey || stripeKey === '') {
        document.getElementById('payment-errors').innerHTML = '<div class="text-red-600 p-4 text-center"><h3 class="font-semibold mb-2">⚠️ Configuration Stripe requise</h3><p class="text-sm">Pour activer les paiements, veuillez:</p><ol class="text-xs mt-2 text-left"><li>1. Créer un compte sur <a href="https://stripe.com" target="_blank" class="underline">stripe.com</a></li><li>2. Récupérer vos clés de test</li><li>3. Les ajouter dans votre fichier .env</li></ol></div>';
        document.getElementById('payment-errors').classList.remove('hidden');
        document.getElementById('submit-payment').disabled = true;
        return;
    }
    
    // Mode développement : avertissement si clés d'exemple
    if (stripeKey.includes('...')) {
        document.getElementById('payment-errors').innerHTML = '<div class="text-yellow-600 p-4 text-center"><h3 class="font-semibold mb-2">⚠️ Mode développement</h3><p class="text-sm">Vous utilisez des clés d\'exemple. Les paiements ne fonctionneront pas.</p><p class="text-xs mt-2">Pour tester les paiements : <a href="https://stripe.com" target="_blank" class="underline">obtenez de vraies clés de test</a></p></div>';
        document.getElementById('payment-errors').classList.remove('hidden');
        document.getElementById('submit-payment').disabled = true;
        return;
    }

    // Gérer la soumission du formulaire
    const submitButton = document.getElementById('submit-payment');
    const form = document.getElementById('checkout-form');

    submitButton.addEventListener('click', async function(event) {
        event.preventDefault();
        
        // Vérifier que le formulaire est valide
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Désactiver le bouton et afficher le spinner
        submitButton.disabled = true;
        document.getElementById('button-text').classList.add('hidden');
        document.getElementById('spinner').classList.remove('hidden');

        // Créer FormData avec les informations de facturation
        const formData = new FormData();
        const token = document.querySelector('input[name="_token"]').value;
        console.log('Token CSRF:', token);
        formData.append('_token', token);
        formData.append('billing_name', document.getElementById('prenom').value + ' ' + document.getElementById('nom').value);
        formData.append('billing_email', document.getElementById('email').value);
        formData.append('billing_address', document.getElementById('adresse').value);
        formData.append('billing_city', document.getElementById('ville').value);
        formData.append('billing_postal_code', document.getElementById('code_postal').value);

        // Soumettre au serveur pour créer la session Stripe
        try {
            console.log('=== DEBUT APPEL FETCH ===');
            const response = await fetch('{{ route("checkout.process") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Pour que Laravel détecte la requête AJAX
                }
            });

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            console.log('Response headers:', response.headers);

            const responseText = await response.text();
            console.log('Response text:', responseText);

            let data;
            try {
                data = JSON.parse(responseText);
                console.log('Parsed data:', data);
            } catch (parseError) {
                console.error('Erreur de parsing JSON:', parseError);
                console.log('Response content:', responseText);
                throw new Error('Réponse invalide du serveur');
            }

            if (response.ok && data.success) {
                console.log('Redirection vers:', data.redirect_url);
                // Rediriger vers Stripe Checkout
                window.location.href = data.redirect_url;
            } else {
                throw new Error(data.error || 'Erreur lors du traitement du paiement');
            }
        } catch (error) {
            console.error('Erreur complète:', error);
            document.getElementById('payment-errors').textContent = error.message || 'Une erreur est survenue lors du traitement du paiement.';
            document.getElementById('payment-errors').classList.remove('hidden');
            
            // Réactiver le bouton
            submitButton.disabled = false;
            document.getElementById('button-text').classList.remove('hidden');
            document.getElementById('spinner').classList.add('hidden');
        }
    });
});
</script>
@endpush
