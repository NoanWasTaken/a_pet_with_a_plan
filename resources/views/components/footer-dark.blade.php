<!-- Footer Dark -->
<footer class="bg-gray-800 text-white">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- À propos -->
            <div>
                <h3 class="text-lg font-semibold mb-4">A Pet with a Plan</h3>
                <p class="text-gray-300 text-sm">
                    Votre partenaire de confiance pour le bien-être et le bonheur de vos animaux de compagnie.
                </p>
            </div>
            
            <!-- Navigation -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Navigation</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Accueil</a></li>
                    <li><a href="{{ route('shop.index') }}" class="text-gray-300 hover:text-white">Boutique</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-white">Blog</a></li>
                    <li><a href="{{ route('faq.index') }}" class="text-gray-300 hover:text-white">FAQ</a></li>
                </ul>
            </div>
            
            <!-- Catégories -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Nos produits</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('shop.index', ['categorie' => 'Chien']) }}" class="text-gray-300 hover:text-white">Pour les chiens</a></li>
                    <li><a href="{{ route('shop.index', ['categorie' => 'Chat']) }}" class="text-gray-300 hover:text-white">Pour les chats</a></li>
                    <li><a href="{{ route('blog.index', ['categorie' => 'Chien']) }}" class="text-gray-300 hover:text-white">Conseils chiens</a></li>
                    <li><a href="{{ route('blog.index', ['categorie' => 'Chat']) }}" class="text-gray-300 hover:text-white">Conseils chats</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li>📧 contact@apetwithaplan.com</li>
                    <li>📞 01 23 45 67 89</li>
                    <li>📍 123 Rue des Animaux, Paris</li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-300">
            <p>&copy; {{ date('Y') }} A Pet with a Plan. Tous droits réservés.</p>
        </div>
    </div>
</footer>
