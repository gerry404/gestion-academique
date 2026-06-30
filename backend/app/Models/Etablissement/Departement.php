<?php
// app/Models/Etablissement/Departement.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    protected $table = 'departements';

    protected $fillable = [
        'code', 'libelle', 'description',
        'est_actif', 'chef_departement_id',
    ];

    protected $casts = ['est_actif' => 'boolean'];

    // un departement a un seul chef 
    public function chefDepartement(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'chef_departement_id');
    }
           //un departement a plusieur  spécialités
    public function specialites(): HasMany
    {
        return $this->hasMany(Specialite::class, 'departement_id');
    }
    //un departement a plusieur niveaux
    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class, 'departement_id');
    }
}