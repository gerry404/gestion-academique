<?php
// app/Models/Etablissement/Departement.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departements';

    protected $fillable = [
        'code',
        'libelle',
        'description',
        'est_actif',
        'chef_departement_id',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    public function chefDepartement()
    {
        return $this->belongsTo(Personnel::class, 'chef_departement_id');
    }

    public function specialites()
    {
        return $this->hasMany(Specialite::class);
    }

    public function niveaux()
    {
        return $this->hasMany(Niveau::class);
    }

    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }
}