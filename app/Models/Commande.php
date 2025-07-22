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
        $total = 0;
        foreach ($this->produits as $produit) {
            $total += $produit->pivot->quantite * $produit->pivot->prix_unitaire;
        }
        return $total / 100; // Convertir en euros pour l'affichage
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
}
