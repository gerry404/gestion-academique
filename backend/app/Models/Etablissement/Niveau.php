<?php
// app/Models/Etablissement/Niveau.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $table = 'niveaux';

    protected $fillable = [
        'libelle', 'departement_id', 'specialite_id', 'annee_academique_id', 'est_actif'
    ];
    //un niveau appartient à un seul departement
    public function departement()  { return $this->belongsTo(Departement::class); }
    //un niveau appartient à une seule spécialité
    public function specialite()   { return $this->belongsTo(Specialite::class); }
    //un niveau appartient à une seule année academique
    public function anneeAcademique() { return $this->belongsTo(AnneeAcademique::class); }
    //un niveau a plusieur matieres
    public function matieres()     { return $this->hasMany(Matiere::class, 'niveau_id'); }
    //un niveau a plusieur unites enseignement
    public function unitesEnseignement() { return $this->hasMany(UniteEnseignement::class, 'niveau_id'); }
    //un niveau a plusieur semestres
    public function semestres(): HasMany
    {
        return $this->hasMany(Semestre::class, 'niveau_id');
    }




    // =============================================
    // SCOPES
    // =============================================

    //permet de filtrer les niveaux par departement
    public function scopeByDepartement($query, $departementId)
    {
        return $query->where('departement_id', $departementId);
    }
    //permet de filtrer les niveaux par spécialité
    public function scopeBySpecialite($query, $specialiteId)
    {
        return $query->where('specialite_id', $specialiteId);
    }
    //permet de filtrer les niveaux par année academique
    public function scopeByAnneeAcademique($query, $anneeId)
    {
        return $query->where('annee_academique_id', $anneeId);
    }
    //permet de filtrer les niveaux actifs
    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }

    // =============================================
    // ACCESSORS
    // =============================================
    //permet d'afficher le libelle complet du niveau
    public function getLibelleCompletAttribute(): string
    {
        return "{$this->libelle} - {$this->specialite?->libelle} ({$this->departement?->libelle})";
    }   
    //permet d'afficher le nom complet du niveau
    public function getNomCompletAttribute(): string
    {
        return "Niveau {$this->libelle}";
    }
    //permet d'afficher le chemin du niveau
    public function getCheminAttribute(): string
    {
        return "{$this->departement?->libelle} > {$this->specialite?->libelle} > {$this->libelle}";
    }
     public function getStatutAttribute(): string
    {
        return $this->est_actif ? 'Actif' : 'Inactif';
    }
}