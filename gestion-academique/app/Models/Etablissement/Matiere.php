<?php
// app/Models/Etablissement/Matiere.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $table = 'matieres';

    protected $fillable = [
        'code',
        'libelle',
        'credit',
        'departement_id',
        'unite_enseignement_id',
        'semestre_id',
        'personnel_id',
        'niveau_id',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function uniteEnseignement()
    {
        return $this->belongsTo(UniteEnseignement::class);
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }
}