#!/bin/bash

echo "🚀 Démarrage de l'environnement de développement..."

# Démarrer les services Docker (incluant Vite automatiquement)
echo "📦 Démarrage des services Docker avec Vite..."
./vendor/bin/sail up -d

# Attendre que les services soient prêts
echo "⏳ Attente du démarrage des services..."
sleep 10

# Vérifier que Vite fonctionne
echo "🔍 Vérification du statut de Vite..."
./vendor/bin/sail logs vite --tail=5

# Exécuter les migrations et seeders si nécessaire
echo "🗄️ Configuration de la base de données..."
./vendor/bin/sail artisan migrate --force
./vendor/bin/sail artisan db:seed --force

# Créer les répertoires de stockage nécessaires
echo "📁 Création des répertoires de stockage..."
./vendor/bin/sail artisan storage:link
./vendor/bin/sail exec laravel.test mkdir -p /var/www/html/storage/framework/sessions
./vendor/bin/sail exec laravel.test mkdir -p /var/www/html/storage/framework/cache
./vendor/bin/sail exec laravel.test mkdir -p /var/www/html/storage/framework/views
./vendor/bin/sail exec laravel.test chmod -R 775 /var/www/html/storage

echo ""
echo "✅ Environnement prêt !"
echo "🌐 Application Laravel : http://localhost"
echo "🔧 Dashboard Admin : http://localhost/admin"
echo "🎨 Vite Dev Server : http://localhost:5173"
echo ""
echo "📊 Services disponibles :"
echo "  - MySQL : localhost:3306"
echo "  - Redis : localhost:6379"
echo "  - Meilisearch : localhost:7700"
echo "  - Mailpit : localhost:8025"
echo ""
echo "Pour arrêter l'environnement :"
echo "  ./vendor/bin/sail down"
echo ""
echo "Pour voir les logs en temps réel :"
echo "  ./vendor/bin/sail logs -f vite"
echo "  ./vendor/bin/sail logs -f laravel.test"
