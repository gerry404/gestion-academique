<?php
// app/Models/Etablissement/Matiere.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Matiere extends Model
{
    protected $table = 'matieres';

    protected $fillable = [
        'code', 'libelle', 'credit',
        'departement_id', 'unite_enseignement_id',
        'semestre_id', 'enseignant_id', 'niveau_id',
    ];

   public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function uniteEnseignement(): BelongsTo
    {
        return $this->belongsTo(UniteEnseignement::class, 'unite_enseignement_id');
    }

    public function semestre(): BelongsTo
    {
        return $this->belongsTo(Semestre::class);
    }

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    // enseignant_id → table enseignants
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }
}