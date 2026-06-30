<?php
// app/Models/Etablissement/Semestre.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $table = 'semestres';

    protected $fillable = ['libelle', 'annee_academique_id'];

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class, 'annee_academique_id');
    }
}