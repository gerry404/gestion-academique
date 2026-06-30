<?php
// app/Models/Etablissement/Specialite.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    protected $table = 'specialites';

    protected $fillable = [
        'code',
        'libelle',
        'departement_id',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function niveaux()
    {
        return $this->hasMany(Niveau::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }
}