<?php
// app/Models/Etablissement/Diplome.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Diplome extends Model
{
    protected $table = 'diplomes';

    protected $fillable = [
        'code',
        'libelle',
        'description',
        'duree_annees',
        'niveau_requis',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'duree_annees' => 'integer',
    ];

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }
}