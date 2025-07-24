<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'A Pet with a Plan'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Styles supplémentaires -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Navigation publique -->
        @include('layouts.public-navigation')
        
        <!-- Messages flash -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 mt-4 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Contenu principal -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        @hasSection('footer')
            @yield('footer')
        @else
            <x-footer-dark />
        @endif

        <!-- Chatbot -->
        <x-chatbot />

        <!-- Scripts supplémentaires -->
        @stack('scripts')
        
        <!-- Script pour le compteur du panier -->
        <script>
            // Mettre à jour le compteur du panier
            function updateCartCount() {
                fetch('/cart/count')
                    .then(response => response.json())
                    .then(data => {
                        const cartCountElement = document.getElementById('cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.count || 0;
                        }
                    })
                    .catch(error => console.error('Erreur lors de la mise à jour du panier:', error));
            }

            // Mettre à jour le compteur au chargement de la page
            document.addEventListener('DOMContentLoaded', updateCartCount);

            // Écouter les événements d'ajout au panier
            document.addEventListener('cart-updated', updateCartCount);
        </script>
    </body>
</html>
