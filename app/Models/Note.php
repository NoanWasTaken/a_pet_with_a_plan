<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $table = 'note';

    protected $fillable = [
        'id_utilisateur',
        'id_produit',
        'note',
        'commentaire',
    ];

    protected $casts = [
        'note' => 'integer',
    ];

    // Récupère l'utilisateur qui possède cette note.
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    // Récupère le produit auquel appartient cette note.
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }

    // Scope pour récupérer les notes avec une note spécifique.
    public function scopeWithRating($query, $rating)
    {
        return $query->where('note', $rating);
    }

    // Scope pour récupérer les notes avec une note supérieure à un seuil.
    public function scopeHighRated($query, $threshold = 4)
    {
        return $query->where('note', '>=', $threshold);
    }

    // Scope pour récupérer les notes avec une note inférieure à un seuil.
    public function scopeLowRated($query, $threshold = 3)
    {
        return $query->where('note', '<=', $threshold);
    }
}
