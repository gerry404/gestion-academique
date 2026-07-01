<?php
// app/Models/Etudiant.php

namespace App\Models;

use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Niveau;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'etudiants';

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'nationalite',
        'pays',
        'telephone',
        'email',
        'adresse',
        'photo',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'date_naissance' => 'date',
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }
}