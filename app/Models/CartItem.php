<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'produit_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer',
    ];

    // Relation avec le panier
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    // Relation avec le produit
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    // Prix en euros
    public function getPriceEurosAttribute()
    {
        return $this->price / 100;
    }

    // Total de la ligne en centimes
    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    // Total de la ligne en euros
    public function getTotalEurosAttribute()
    {
        return $this->total / 100;
    }

    // Prix formaté selon la devise de l'utilisateur
    public function getPriceFormateAttribute()
    {
        if (auth()->check()) {
            return auth()->user()->formatPrice($this->price);
        }
        
        return \App\Models\User::formatPriceGuest($this->price);
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
