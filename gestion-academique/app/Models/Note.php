<?php
// app/Models/Note.php

namespace App\Models;

use App\Models\Etablissement\Matiere;
use App\Models\Etablissement\Semestre;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $fillable = [
        'etudiant_id',
        'matiere_id',
        'inscription_id',
        'semestre_id',
        'note_cc',
        'note_examen',
        'moyenne',
        'credit',
      
    ];

    protected $casts = [
        'note_cc' => 'decimal:2',
        'note_examen' => 'decimal:2',
        'moyenne' => 'decimal:2',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    // Calcul automatique de la moyenne
    public static function calculateMoyenne($cc, $examen)
    {
        return ($cc * 0.3) + ($examen * 0.7);
    }

    public function getMentionAttribute()
    {
        $moyenne = $this->moyenne;
        if ($moyenne >= 16) return 'Très bien';
        if ($moyenne >= 14) return 'Bien';
        if ($moyenne >= 12) return 'Assez bien';
        if ($moyenne >= 10) return 'Passable';
        return 'Insuffisant';
    }

    public function getEstValideAttribute()
    {
        return $this->moyenne >= 10;
    }
}