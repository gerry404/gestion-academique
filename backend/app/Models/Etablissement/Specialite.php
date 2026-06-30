<?php
// app/Models/Etablissement/Specialite.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    protected $table = 'specialites';

    protected $fillable = ['code', 'libelle', 'departement_id', 'est_actif'];

    protected $casts = ['est_actif' => 'boolean'];

    //une spécialité appartient à un seul departement
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
    //une spécialité a plusieur niveaux
    public function niveaux()
    {
        return $this->hasMany(Niveau::class, 'specialite_id');
    }
}