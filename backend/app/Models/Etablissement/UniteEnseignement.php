<?php
// app/Models/Etablissement/UniteEnseignement.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class UniteEnseignement extends Model
{
    protected $table = 'unites_enseignement';

    protected $fillable = [
        'code', 'libelle', 'total_credit',
        'position_releve', 'annee_academique_id', 'niveau_id',
    ];

    public function niveau()          { return $this->belongsTo(Niveau::class); }
    public function anneeAcademique() { return $this->belongsTo(AnneeAcademique::class); }
    public function matieres()        { return $this->hasMany(Matiere::class, 'unite_enseignement_id'); }
}