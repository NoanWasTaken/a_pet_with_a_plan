<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'utilisateur';

    // The attributes that are mass assignable.
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'statut',
        'devise_preferee',
    ];

    // The attributes that should be hidden for serialization.
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    // Get the attributes that should be cast.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mot_de_passe' => 'hashed',
        ];
    }

    // Récupère le mot de passe pour l'authentification.
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    // Récupère le nom de l'attribut mot de passe.
    public function getAuthPasswordName()
    {
        return 'mot_de_passe';
    }

    // Mutateur pour le champ password (pour la compatibilité avec Laravel Auth)
    public function getPasswordAttribute()
    {
        return $this->mot_de_passe;
    }

    // Mutateur pour définir le password (redirige vers mot_de_passe)
    public function setPasswordAttribute($value)
    {
        $this->attributes['mot_de_passe'] = $value;
    }

    // Récupère l'attribut nom complet.
    public function getFullNameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // Vérifie si l'utilisateur est administrateur.
    public function isAdmin()
    {
        return $this->statut === 'admin';
    }

    // Vérifie si l'utilisateur est modérateur.
    public function isModerator()
    {
        return $this->statut === 'moderateur';
    }

    // Récupère les articles de l'utilisateur.
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'id_utilisateur');
    }

    // Récupère les notes de l'utilisateur.
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'id_utilisateur');
    }

    // Récupère les commandes de l'utilisateur.
    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class, 'id_utilisateur');
    }

    // Récupère le panier de l'utilisateur.
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    // Récupère le symbole de la devise préférée
    public function getCurrencySymbol()
    {
        $devise = $this->devise_preferee ?? 'EUR';
        
        $symbols = [
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            'CAD' => 'C$',
        ];
        
        return $symbols[$devise] ?? '€';
    }

    // Formate le prix avec le symbole de devise approprié
    public function formatPrice($priceInCents)
    {
        $priceInEuros = $priceInCents / 100;
        $convertedPrice = $this->convertFromEuros($priceInEuros);
        $symbol = $this->getCurrencySymbol();
        
        return number_format($convertedPrice, 2, ',', ' ') . ' ' . $symbol;
    }

    // Convertit un prix en euros vers la devise préférée de l'utilisateur
    public function convertFromEuros($priceInEuros)
    {
        $devise = $this->devise_preferee ?? 'EUR';
        
        // Taux de change approximatifs (dans un vrai projet, utiliser une API)
        $exchangeRates = [
            'EUR' => 1.0,
            'USD' => 1.10,
            'GBP' => 0.85,
            'CAD' => 1.50,
        ];
        
        $rate = $exchangeRates[$devise] ?? 1.0;
        return $priceInEuros * $rate;
    }

    // Convertit un prix de la devise préférée vers des centimes d'euros (pour Stripe)
    public function convertToEurosCents($priceInUserCurrency)
    {
        $devise = $this->devise_preferee ?? 'EUR';
        
        // Taux de change approximatifs (inverses)
        $exchangeRates = [
            'EUR' => 1.0,
            'USD' => 1/1.10,
            'GBP' => 1/0.85,
            'CAD' => 1/1.50,
        ];
        
        $rate = $exchangeRates[$devise] ?? 1.0;
        $priceInEuros = $priceInUserCurrency * $rate;
        return (int) round($priceInEuros * 100);
    }

    // Méthode statique pour formater le prix pour les invités
    public static function formatPriceGuest($priceInCents)
    {
        $priceInEuros = $priceInCents / 100;
        return number_format($priceInEuros, 2, ',', ' ') . ' €';
    }
}
