# 🐾 A Pet with a Plan

Site e-commerce de vente d'accessoires et services pour animaux de compagnie.

## Installation et Lancement du Projet

### Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **Docker Desktop** (macOS/Windows) ou **Docker Engine** (Linux)
- **Git**
- **Composer** (pour Laravel Sail)

### Installation Rapide

1. **Cloner le repository**
   ```bash
   git clone https://github.com/NoanWasTaken/a_pet_with_a_plan.git
   cd a_pet_with_a_plan
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Configurer l'environnement**
   ```bash
   # Copier le fichier d'environnement
   cp .env.example .env
   
   # Générer la clé d'application Laravel
   ./vendor/bin/sail artisan key:generate
   ```

4. **Démarrer l'environnement de développement**
   ```bash
   # Option 1: Script automatique (recommandé)
   chmod +x dev-start.sh (seulement la première fois)
   ./dev-start.sh
   
   # Option 2: Commandes manuelles
   ./vendor/bin/sail up -d
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```

### Accès à l'Application

- **Application Laravel :** http://localhost
- **Dashboard Admin :** http://localhost/admin
- **Serveur Vite (dev) :** http://localhost:5173

### Comptes de Test

Après le seeding, vous pouvez utiliser ces comptes :

```bash
# Voir tous les utilisateurs créés
./vendor/bin/sail artisan tinker
>>> User::all(['email', 'role']);
```

## Commandes de Développement

### Gestion des Services Docker

```bash
# Démarrer tous les services
./vendor/bin/sail up -d

# Arrêter tous les services
./vendor/bin/sail down

# Redémarrer un service spécifique
./vendor/bin/sail restart vite
./vendor/bin/sail restart laravel.test

# Voir les logs
./vendor/bin/sail logs laravel.test
./vendor/bin/sail logs vite
./vendor/bin/sail logs mysql
```

### Base de Données

```bash
# Exécuter les migrations
./vendor/bin/sail artisan migrate

# Réinitialiser complètement la BDD avec données de test
./vendor/bin/sail artisan migrate:fresh --seed

# Accéder à MySQL
./vendor/bin/sail mysql

# Créer une nouvelle migration
./vendor/bin/sail artisan make:migration create_example_table
```

### Assets Frontend (CSS/JS)

```bash
# Mode développement (avec hot reload)
./vendor/bin/sail npm run dev

# Installer les dépendances npm
./vendor/bin/sail npm install

# Compilation pour la production
./vendor/bin/sail npm run build

# Vérifier les assets compilés
ls -la public/build/assets/
```

### Cache et Optimisation

```bash
# Nettoyer tous les caches Laravel
./vendor/bin/sail artisan optimize:clear

# Nettoyer un cache spécifique
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear
```

## Structure du Projet

### Fonctionnalités Principales

- **Dashboard Admin** (`/admin`) - Accès sécurisé pour admins et modérateurs
- **CRUD Complet** pour :
  -  Utilisateurs
  -  Produits (avec upload d'images)
  -  Articles (avec upload d'images)
  -  Questions (FAQ)
  -  Notes/Avis
  -  Commandes

### Technologies Utilisées

- **Backend :** Laravel 11 avec PHP 8.4
- **Frontend :** Blade Templates + Tailwind CSS + Vite
- **Base de Données :** MySQL 8.0
- **Containerisation :** Docker avec Laravel Sail
- **Cache :** Redis
- **Recherche :** Meilisearch
- **Mail :** Mailpit (développement)

### Architecture

```
app/
├── Http/Controllers/          # Contrôleurs CRUD
├── Models/                   # Modèles Eloquent
├── Http/Middleware/          # Middleware (AdminMiddleware)
└── Http/Requests/           # Validation des formulaires

resources/
├── views/                   # Templates Blade
├── css/app.css             # Styles Tailwind
└── js/app.js               # JavaScript

database/
├── migrations/             # Migrations de base de données
└── seeders/               # Données de test
```

## Sécurité et Accès

### Middleware de Sécurité

- **AdminMiddleware** : Vérifie les rôles `admin` et `moderateur`
- Protection CSRF sur tous les formulaires
- Validation des uploads d'images

### Gestion des Rôles

```php
// Rôles disponibles
'user'       // Utilisateur standard
'moderateur' // Modérateur (accès admin limité)
'admin'      // Administrateur complet
```

## Résolution de Problèmes

### Problème : Assets CSS/JS non chargés

```bash
# Vérifier que Vite fonctionne
./vendor/bin/sail logs vite

# Redémarrer Vite si nécessaire
./vendor/bin/sail restart vite

# Nettoyer le cache
./vendor/bin/sail artisan optimize:clear
```

### Problème : Base de données inaccessible

```bash
# Vérifier le statut de MySQL
./vendor/bin/sail logs mysql

# Redémarrer MySQL
./vendor/bin/sail restart mysql

# Vérifier la connexion
./vendor/bin/sail artisan tinker
>>> DB::connection()->getPdo();
```

### Problème : Ports déjà utilisés

Modifier les ports dans `.env` :
```env
APP_PORT=8080              # Au lieu de 80
FORWARD_DB_PORT=3307       # Au lieu de 3306
FORWARD_VITE_PORT=5174     # Au lieu de 5173
```

## Notes de Développement

### Prix des Produits

Les prix sont stockés en **centimes** dans la base de données mais affichés en **euros** :

```php
// Dans le modèle Produit
public function setPrixAttribute($value) {
    $this->attributes['prix'] = $value * 100; // Conversion euros → centimes
}

public function getPrixEurosAttribute() {
    return $this->prix / 100; // Conversion centimes → euros
}
```

### Upload d'Images

- **Produits :** Upload + suppression automatique
- **Articles :** Upload seulement (pas de suppression automatique)
- Stockage dans `storage/app/public/`
