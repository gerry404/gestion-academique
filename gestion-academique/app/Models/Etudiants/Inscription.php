<?php
// app/Models/Inscription.php

namespace App\Models\Etudiants;

use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\Specialite;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $table = 'inscriptions';

    protected $fillable = [
        'etudiant_id',
        'annee_academique_id',
        'departement_id',
        'specialite_id',
        'niveau_id',
        'date_inscription',
        'statut',
        'commentaire',
    ];

    protected $casts = [
        'date_inscription' => 'date',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }
}