<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $table = 'article';

    protected $fillable = [
        'titre',
        'description',
        'contenu',
        'image',
        'banniere_article',
        'date_publication',
        'id_utilisateur',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
    ];

    // Récupère l'utilisateur qui possède cet article.
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    // Récupère le nom de l'auteur.
    public function getAuthorNameAttribute()
    {
        return $this->utilisateur ? $this->utilisateur->full_name : 'Auteur inconnu';
    }

    // Scope pour récupérer les articles publiés.
    public function scopePublished($query)
    {
        return $query->where('date_publication', '<=', now());
    }

    // Scope pour récupérer les articles récents.
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('date_publication', '>=', now()->subDays($days));
    }
}
