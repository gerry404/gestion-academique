<?php

namespace App\Models\Etablissement;

use App\Models\Etablissement\User;
use Illuminate\Database\Eloquent\Builder; // <-- AJOUT DE L'IMPORTATION DU BUILDER
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Personnel extends Model
{
    protected $table = 'personnels';

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'telephone',
        'email',
        'adresse',
        'photo',
        'diplome',
        'fonction',
        'date_embauche',
        'est_actif',
        'user_id',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'date_naissance' => 'date',
        'date_embauche' => 'date',
    ];

    // Compte utilisateur lié (optionnel)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Matières enseignées (si est_enseignant = true)
    public function matieres(): HasMany
    {
        return $this->hasMany(Matiere::class, 'enseignant_id');
    }


    /** Département dont il est chef */
    public function departementDirige(): HasOne
    {
        return $this->hasOne(Departement::class, 'chef_departement_id');
    }
    // Accesseur pratique
    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    // Scope : actifs seulement (Typé avec Builder)
    public function scopeActifs(Builder $query): Builder
    {
        return $query->where('est_actif', true);
    }
   

    public function scopeAvecCompte( Builder $query): Builder
    {
        return $query->whereNotNull('user_id');
    }

    public function scopeSansCompte( Builder $query): Builder
    {
        return $query->whereNull('user_id');
    }
}
