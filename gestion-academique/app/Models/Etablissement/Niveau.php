<?php
// app/Models/Etablissement/Niveau.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $table = 'niveaux';

    protected $fillable = [
        'libelle',
        'departement_id',
        'specialite_id',
        'annee_academique_id',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function unitesEnseignement()
    {
        return $this->hasMany(UniteEnseignement::class);
    }

    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }

    public function semestres()
    {
        return $this->hasMany(Semestre::class);
    }

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }
}