<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commande';

    protected $fillable = [
        'id_utilisateur',
        'date_commande',
        'total',
        'statut',
        'devise',
        'stripe_session_id',
        'stripe_payment_intent',
    ];

    protected $casts = [
        'date_commande' => 'datetime',
    ];

    // Récupère l'utilisateur qui possède cette commande.
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    // Récupère les produits de cette commande.
    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class, 'commande_produit', 'id_commande', 'id_produit')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }
    
    // Calcule le montant total de la commande.
    public function getPrixTotalAttribute()
    {
        // Si le total est stocké en base, l'utiliser (Stripe stocke en centimes)
        if ($this->attributes['total'] > 0) {
            return $this->attributes['total'] / 100;
        }
        
        // Sinon, calculer à partir des produits (fallback)
        $total = 0;
        foreach ($this->produits as $produit) {
            $total += $produit->pivot->quantite * $produit->pivot->prix_unitaire;
        }
        return $total / 100; // Convertir en euros pour l'affichage
    }

    // Récupère le total formaté avec la devise
    public function getTotalFormateAttribute()
    {
        $total = $this->prix_total;
        $devise = $this->devise ?? 'EUR';
        
        $symbols = [
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            'CAD' => 'C$',
        ];

        $symbol = $symbols[$devise] ?? $devise;
        
        return number_format($total, 2, ',', ' ') . ' ' . $symbol;
    }

    // Formate un prix en centimes avec la devise de la commande
    public function formatPrix($priceInCents)
    {
        // Les prix sont déjà stockés dans la devise de la commande
        $priceInMainUnit = $priceInCents / 100;
        $devise = $this->devise ?? 'EUR';
        
        $symbols = [
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            'CAD' => 'C$',
        ];

        $symbol = $symbols[$devise] ?? $devise;
        
        return number_format($priceInMainUnit, 2, ',', ' ') . ' ' . $symbol;
    }

    // Scope pour récupérer les commandes récentes.
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('date_commande', '>=', now()->subDays($days));
    }

    // Scope pour récupérer les commandes d'aujourd'hui.
    public function scopeToday($query)
    {
        return $query->whereDate('date_commande', today());
    }

    // Scope pour récupérer les commandes de cette semaine.
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('date_commande', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    // Scope pour récupérer les commandes de ce mois.
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date_commande', now()->month)
                    ->whereYear('date_commande', now()->year);
    }

    // Récupère les statuts disponibles.
    public static function getStatuts()
    {
        return [
            'en_attente' => 'En attente',
            'confirmee' => 'Confirmée',
            'en_cours' => 'En cours',
            'livree' => 'Livrée',
            'annulee' => 'Annulée',
            'echouee' => 'Échouée',
        ];
    }

    // Formatte le statut pour l'affichage.
    public function getStatutFormateAttribute()
    {
        return self::getStatuts()[$this->statut] ?? $this->statut;
    }

    // Récupère la classe CSS pour le statut.
    public function getStatutCssClassAttribute()
    {
        return match($this->statut) {
            'en_attente' => 'bg-yellow-100 text-yellow-800',
            'confirmee' => 'bg-blue-100 text-blue-800',
            'en_cours' => 'bg-purple-100 text-purple-800',
            'livree' => 'bg-green-100 text-green-800',
            'annulee' => 'bg-gray-100 text-gray-800',
            'echouee' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
