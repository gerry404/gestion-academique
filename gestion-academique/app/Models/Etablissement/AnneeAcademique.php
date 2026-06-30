<?php
// app/Models/Etablissement/AnneeAcademique.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class AnneeAcademique extends Model
{
    protected $table = 'annees_academiques';

    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'note_validation',
        'est_active',
        'description',
    ];

    protected $casts = [
        'est_active' => 'boolean',
        'note_validation' => 'decimal:2',
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function semestres()
    {
        return $this->hasMany(Semestre::class);
    }

    public function niveaux()
    {
        return $this->hasMany(Niveau::class);
    }

    public function unitesEnseignement()
    {
        return $this->hasMany(UniteEnseignement::class);
    }

    public function scopeActive($query)
    {
        return $query->where('est_active', true);
    }
}