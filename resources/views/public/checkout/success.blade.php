@extends('layouts.public')

@section('title', 'Commande confirmée - A Pet with a Plan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Icône de succès -->
            <div class="text-6xl mb-6">✅</div>
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Commande confirmée !
            </h1>
            
            <p class="text-lg text-gray-600 mb-8">
                Merci pour votre achat ! Votre commande a été traitée avec succès.
            </p>
            
            @if(isset($commande))
                <div class="bg-white rounded-lg shadow-md p-6 mb-8 text-left">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Détails de la commande</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-600">Numéro de commande :</span>
                            <span class="text-gray-800">#{{ $commande->id }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Date :</span>
                            <span class="text-gray-800">{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Total :</span>
                            <span class="text-gray-800 font-semibold">
                                @if(auth()->check())
                                    {{ auth()->user()->formatPrice($commande->total) }}
                                @else
                                    {{ \App\Models\User::formatPriceGuest($commande->total) }}
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Statut :</span>
                            <span class="text-green-600 font-medium">{{ $commande->statut }}</span>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <div class="text-blue-500 mr-3 mt-1">📧</div>
                    <div class="text-left">
                        <h3 class="font-medium text-blue-800 mb-2">Confirmation par email</h3>
                        <p class="text-sm text-blue-600">
                            Un email de confirmation a été envoyé à votre adresse email avec tous les détails de votre commande.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <div class="text-orange-500 mr-3 mt-1">🚚</div>
                    <div class="text-left">
                        <h3 class="font-medium text-orange-800 mb-2">Livraison</h3>
                        <p class="text-sm text-orange-600">
                            Votre commande sera expédiée sous 2-3 jours ouvrés. Vous recevrez un email de suivi avec le numéro de colis.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('orders.index') }}" 
                   class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300">
                    Voir mes commandes
                </a>
                <a href="{{ route('shop.index') }}" 
                   class="bg-gray-100 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-300">
                    Continuer les achats
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
