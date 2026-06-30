<?php

namespace App\Models\Etablissement;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Etablissement\Semestre;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\UniteEnseignement;


class AnneeAcademique extends Model
{
   

    protected $table = 'annees_academiques';

    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'note_validation',
        'est_active',
        'description',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'est_active' => 'boolean',
        'note_validation' => 'decimal:2',
    ];


   public function semestres(): HasMany
    {
        return $this->hasMany(Semestre::class, 'annee_academique_id');
    }
   
    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class, 'annee_academique_id');
    }

    /*public function unitesEnseignement(): HasMany
    {
        return $this->hasMany(UniteEnseignement::class, 'annee_academique_id');
    }

    /** Désactive toutes les autres années avant d'activer celle-ci */
    public function activer(): void
    {
        self::where('id', '!=', $this->id, 'and')->update(['statut' => 'inactif']);
        $this->update(['statut' => 'actif']);
    }
}