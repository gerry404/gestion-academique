<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'email',
        'telephone',
        'adresse',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date:Y-m-d',
        ];
    }
}
