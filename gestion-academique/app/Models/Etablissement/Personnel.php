<?php
// app/Models/Etablissement/Personnel.php

namespace App\Models\Etablissement;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $table = 'personnels';

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'telephone',
        'email',
        'adresse',
        'photo',
        'diplome',
        'fonction',
        'date_embauche',
        'specialite',
        'est_actif',
        'user_id',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'date_naissance' => 'date',
        'date_embauche' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departementDirige()
    {
        return $this->hasOne(Departement::class, 'chef_departement_id');
    }

    public function matieres()
    {
        return $this->hasMany(Matiere::class, 'personnel_id');
    }

    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }

    public function scopeSansCompte($query)
    {
        return $query->whereNull('user_id');
    }

    public function scopeAvecCompte($query)
    {
        return $query->whereNotNull('user_id');
    }
}