<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
