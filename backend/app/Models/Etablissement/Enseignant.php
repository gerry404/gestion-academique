<?php
// app/Models/Etablissement/Enseignant.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Enseignant extends Model
{
    protected $table = 'enseignants';

    protected $fillable = [
        'matricule', 'nom', 'prenom', 'sexe',
        'date_naissance', 'lieu_naissance',
        'telephone', 'email', 'adresse',
        'photo', 'diplome', 'specialite',
        'grade', 'date_embauche', 'est_actif',
    ];

    protected $casts = [
        'est_actif'      => 'boolean',
        'date_naissance' => 'date',
        'date_embauche'  => 'date',
    ];

    public function matieres(): HasMany
    {
        return $this->hasMany(Matiere::class, 'enseignant_id');
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function scopeActifs( Builder $query): Builder
    {
        return $query->where('est_actif', true);
    }
}