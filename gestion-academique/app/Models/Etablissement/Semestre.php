<?php
// app/Models/Etablissement/Semestre.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $table = 'semestres';

    protected $fillable = [
        'libelle',
        'annee_academique_id',
        'niveau_id', // ✅ 
    ];

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }
     public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
}