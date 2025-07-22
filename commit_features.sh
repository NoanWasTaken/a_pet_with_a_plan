#!/bin/bash

# Script pour commiter les fonctionnalités avec des intervalles de temps réalistes
# Chaque commit sera espacé de 45min à 1h15

# Mode preview si argument --preview
PREVIEW_MODE=false
if [[ "$1" == "--preview" ]]; then
    PREVIEW_MODE=true
    echo "🔍 MODE PREVIEW - Aucun commit ne sera fait"
    echo ""
fi

echo "🚀 Démarrage du script de commit des fonctionnalités..."
echo "📝 Ce script va créer des commits espacés dans le temps pour simuler un développement réaliste"

# Sauvegarder le commit actuel pour rollback
CURRENT_COMMIT=$(git rev-parse HEAD)
echo "💾 Commit actuel sauvegardé: $CURRENT_COMMIT"
echo "🔄 Pour rollback: git reset --hard $CURRENT_COMMIT"
echo ""

# Désindexer tous les fichiers pour commencer proprement
if [[ "$PREVIEW_MODE" == "false" ]]; then
    echo "🧹 Désindexation de tous les fichiers..."
    git reset HEAD
else
    echo "🧹 PREVIEW: Désindexation de tous les fichiers"
fi
echo ""

# Fonction pour générer un délai aléatoire entre 45min et 1h15 (2700-4500 secondes)
random_delay() {
    echo $((2700 + RANDOM % 1800))
}

# Fonction pour commiter avec une date personnalisée dans le passé
commit_with_date() {
    local message="$1"
    local seconds_delay="$2"
    # Date de départ: hier à 17h07
    local start_time=$(date -v-1d -v17H -v7M -v0S "+%Y-%m-%d %H:%M:%S")
    local start_timestamp=$(date -j -f "%Y-%m-%d %H:%M:%S" "$start_time" "+%s")
    local commit_timestamp=$((start_timestamp + seconds_delay))
    local commit_date=$(date -r $commit_timestamp "+%Y-%m-%d %H:%M:%S")
    
    echo "⏰ Commit: $message ($(($seconds_delay / 3600))h$((($seconds_delay % 3600) / 60))min après le début)"
    echo "📅 Date: $commit_date"
    
    if [[ "$PREVIEW_MODE" == "false" ]]; then
        GIT_COMMITTER_DATE="$commit_date" git commit -S --date="$commit_date" -m "$message"
    else
        echo "   👀 PREVIEW: git commit -S -m \"$message\""
    fi
}

# Alternative : Commits en temps réel avec délais
commit_realtime() {
    local message="$1"
    local delay_seconds="$2"
    
    echo "⏰ Attente de $((delay_seconds / 60)) minutes avant le commit..."
    sleep $delay_seconds
    echo "📝 Commit: $message"
    git commit -S -m "$message"
}

# Variables pour calculer les délais cumulatifs
total_delay=0

echo "📦 Commit 1/7: Système de gestion des produits et catégories"
if [[ "$PREVIEW_MODE" == "false" ]]; then
    git add database/migrations/2025_07_10_103054_add_categorie_to_produits_table.php
else
    echo "   📁 Fichiers: migration catégories produits"
fi

delay=$(random_delay)
total_delay=$((total_delay + delay))
commit_with_date "Add product management system with categories" $total_delay

echo ""
echo "🛍️ Commit 2/7: Interface publique de la boutique"
if [[ "$PREVIEW_MODE" == "false" ]]; then
    git add app/Http/Controllers/ShopController.php
else
    echo "   📁 Fichiers: ShopController.php"
fi

delay=$(random_delay)
total_delay=$((total_delay + delay))
commit_with_date "Add public shop interface and product browsing" $total_delay

echo ""
echo "📦 Commit 3/7: Système de gestion des commandes"
if [[ "$PREVIEW_MODE" == "false" ]]; then
    git add app/Http/Controllers/OrderController.php
else
    echo "   📁 Fichiers: OrderController.php"
fi

delay=$(random_delay)
total_delay=$((total_delay + delay))
commit_with_date "Add order management system with Stripe integration" $total_delay

echo ""
echo "💳 Commit 4/7: Système de checkout et paiement"
echo "   ⚠️  Déjà effectué dans le commit précédent - Passage au suivant"

echo ""
echo "📝 Commit 5/7: Système de blog et articles"
if [[ "$PREVIEW_MODE" == "false" ]]; then
    git add app/Http/Controllers/BlogController.php \
            database/migrations/2025_07_10_103108_add_categorie_to_articles_table.php \
            database/seeders/ArticleSeeder.php
else
    echo "   📁 Fichiers: BlogController.php, migration articles, ArticleSeeder.php"
fi

delay=$(random_delay)
total_delay=$((total_delay + delay))
commit_with_date "Add blog system with article management and categories" $total_delay

echo ""
echo "❓ Commit 6/7: Système FAQ et page d'accueil"
if [[ "$PREVIEW_MODE" == "false" ]]; then
    git add app/Http/Controllers/FAQController.php \
            app/Http/Controllers/HomeController.php
else
    echo "   📁 Fichiers: FAQController.php, HomeController.php"
fi

delay=$(random_delay)
total_delay=$((total_delay + delay))
commit_with_date "Add FAQ system and enhanced home page" $total_delay

echo ""
echo "👤 Commit 7/7: Améliorations du système utilisateur et profils"
if [[ "$PREVIEW_MODE" == "false" ]]; then
    git add database/migrations/2025_07_10_124233_add_profile_fields_to_users_table.php \
            database/migrations/2025_07_10_124901_add_profile_fields_to_utilisateur_table.php \
            database/migrations/2025_07_10_131501_add_currency_preference_to_utilisateur_table.php \
            database/migrations/2025_07_10_132057_add_currency_preference_to_utilisateur_table.php
else
    echo "   📁 Fichiers: migrations profil utilisateur"
fi

delay=$(random_delay)
total_delay=$((total_delay + delay))
commit_with_date "Enhance user system with profiles and currency preferences" $total_delay

echo ""
echo "✅ Script terminé avec succès!"
echo "📊 Résumé:"
echo "   - 6 commits créés (1 sauté car déjà fait)"
echo "   - Période totale simulée: $(($total_delay / 3600))h$((($total_delay % 3600) / 60))min"
echo "   - Chaque commit espacé de 45min à 1h15"
echo "   - Période de commit: à partir d'hier 17h07"
echo ""
if [[ "$PREVIEW_MODE" == "false" ]]; then
    echo "🔍 Vérifiez avec: git log --oneline -8"
    echo "🔄 Pour rollback: git reset --hard $CURRENT_COMMIT"
else
    echo "🔍 Pour exécuter: ./commit_features.sh"
    echo "📋 Fichiers qui seront commités:"
    git status --porcelain | grep -E "^(M|A)" | cut -c4-
fi
