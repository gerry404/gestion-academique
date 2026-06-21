<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matiere extends Model
{
    use HasFactory;

    protected $table = 'matieres';

    protected $fillable = [
        'code',
        'libelle',
        'coefficient',
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
