<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produit';

    protected $fillable = [
        'nom',
        'prix',
        'description',
        'image',
    ];

    protected $casts = [
        'prix' => 'integer',
    ];

    // Mutateur pour convertir les euros en centimes pour le stockage
    public function setPrixAttribute($value)
    {
        // Convertir les virgules en points pour la compatibilité française
        $value = str_replace(',', '.', $value);
        // Convertir les euros en centimes (multiplier par 100)
        $this->attributes['prix'] = (int) round(floatval($value) * 100);
    }

    // Accesseur pour afficher le prix en euros
    public function getPrixEurosAttribute()
    {
        return $this->prix / 100;
    }

    // Accesseur pour afficher le prix formaté selon la devise de l'utilisateur
    public function getPrixFormateAttribute()
    {
        if (auth()->check()) {
            return auth()->user()->formatPrice($this->prix);
        }
        
        return User::formatPriceGuest($this->prix);
    }

    // Récupère les notes pour ce produit.
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'id_produit');
    }
    
    // Récupère les commandes contenant ce produit.
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_produit', 'id_produit', 'id_commande')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }

    // Récupère la note moyenne pour ce produit.
    public function getAverageRatingAttribute()
    {
        return $this->notes()->avg('note');
    }

    // Récupère le nombre total d'avis pour ce produit.
    public function getTotalReviewsAttribute()
    {
        return $this->notes()->count();
    }
}
