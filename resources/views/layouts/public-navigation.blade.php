<nav class="bg-white shadow-lg w-full">
    <div class="container mx-auto px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo et navigation principale -->
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="text-2xl font-bold text-black">🐾 A Pet with a Plan</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex md:ml-10 space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-700 hover:text-gray-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'border-b' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('shop.index') }}" 
                       class="text-gray-700 hover:text-gray-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('shop.*') ? 'border-b' : '' }}">
                        Boutique
                    </a>
                    <a href="{{ route('blog.index') }}" 
                       class="text-gray-700 hover:text-gray-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('blog.*') ? 'border-b' : '' }}">
                        Blog
                    </a>
                    <a href="{{ route('faq.index') }}" 
                       class="text-gray-700 hover:text-gray-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('faq.*') ? 'border-b' : '' }}">
                        FAQ
                    </a>
                </div>

            <!-- Actions à droite -->
            <div class="flex items-center space-x-4">
                <!-- Panier -->
                @auth
                    <a href="{{ route('cart.index') }}" 
                       class="text-gray-700 hover:text-gray-600 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M9 19v1a1 1 0 102 0v-1m0 0a1 1 0 012 0v1m0 0h2"></path>
                        </svg>
                        @php
                            $cartCount = auth()->user()->cart ? auth()->user()->cart->total_items : 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-gray-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-gray-600 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M9 19v1a1 1 0 102 0v-1m0 0a1 1 0 012 0v1m0 0h2"></path>
                        </svg>
                    </a>
                @endauth

                @auth
                    <!-- Utilisateur connecté -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center text-sm text-gray-700 hover:text-gray-600 focus:outline-none">
                            <span class="mr-2">{{ auth()->user()->full_name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            
                            <a href="{{ route('orders.index') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Mes commandes
                            </a>
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Mon profil
                            </a>
                            
                            @if(auth()->user()->isAdmin() || auth()->user()->isModerator())
                                <div class="border-t border-gray-100"></div>
                                <a href="{{ route('dashboard') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Administration
                                </a>
                            @endif
                            
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Utilisateur non connecté -->
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-gray-600 px-3 py-2 rounded-md text-sm font-medium">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-gray-800 text-white hover:bg-gray-700 px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                            Inscription
                        </a>
                    </div>
                @endauth

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button x-data="{ mobileOpen: false }" 
                            @click="mobileOpen = !mobileOpen"
                            type="button" 
                            class="text-gray-700 hover:text-gray-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-data="{ mobileOpen: false }" 
         x-show="mobileOpen" 
         class="md:hidden bg-white border-t border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" 
               class="block px-3 py-2 text-gray-700 hover:text-gray-600 {{ request()->routeIs('home') ? 'text-gray-600 bg-gray-50' : '' }}">
                Accueil
            </a>
            <a href="{{ route('shop.index') }}" 
               class="block px-3 py-2 text-gray-700 hover:text-gray-600 {{ request()->routeIs('shop.*') ? 'text-gray-600 bg-gray-50' : '' }}">
                Boutique
            </a>
            <a href="{{ route('blog.index') }}" 
               class="block px-3 py-2 text-gray-700 hover:text-gray-600 {{ request()->routeIs('blog.*') ? 'text-gray-600 bg-gray-50' : '' }}">
                Blog
            </a>
            <a href="{{ route('faq.index') }}" 
               class="block px-3 py-2 text-gray-700 hover:text-gray-600 {{ request()->routeIs('faq.*') ? 'text-gray-600 bg-gray-50' : '' }}">
                FAQ
            </a>
            <a href="{{ route('cart.index') }}" 
               class="block px-3 py-2 text-gray-700 hover:text-gray-600">
                Panier
            </a>
            
            @auth
                <div class="border-t border-gray-200 pt-4">
                    <div class="px-3 py-2 text-sm text-gray-500">{{ auth()->user()->full_name }}</div>
                    <a href="{{ route('orders.index') }}" 
                       class="block px-3 py-2 text-gray-700 hover:text-gray-600">
                        Mes commandes
                    </a>
                    <a href="{{ route('profile.edit') }}" 
                       class="block px-3 py-2 text-gray-700 hover:text-gray-600">
                        Mon profil
                    </a>
                    
                    @if(auth()->user()->isAdmin() || auth()->user()->isModerator())
                        <a href="{{ route('dashboard') }}" 
                           class="block px-3 py-2 text-gray-700 hover:text-gray-600">
                            Administration
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="block w-full text-left px-3 py-2 text-gray-700 hover:text-gray-600">
                            Déconnexion
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-200 pt-4">
                    <a href="{{ route('login') }}" 
                       class="block px-3 py-2 text-gray-700 hover:text-gray-600">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" 
                       class="block px-3 py-2 bg-gray-600 text-white rounded-md mx-3">
                        Inscription
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
