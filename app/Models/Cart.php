<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
    ];

    // Relation avec l'utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les articles du panier
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // Calculer le total du panier
    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    // Calculer le total en euros
    public function getTotalEurosAttribute()
    {
        return $this->total / 100;
    }

    // Calculer le nombre total d'articles
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    // Total formaté selon la devise de l'utilisateur
    public function getTotalFormateAttribute()
    {
        if (auth()->check()) {
            return auth()->user()->formatPrice($this->total);
        }
        
        return \App\Models\User::formatPriceGuest($this->total);
    }
}
