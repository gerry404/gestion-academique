<?php
// app/Http/Requests/Etablissement/UpdateAnneeAcademiqueRequest.php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAnneeAcademiqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $anneeAcademique = $this->route('anneeAcademique');
        return [
            'libelle' => ['required', 'string', 'max:20',  Rule::unique('annees_academiques', 'libelle')
        ->ignore($anneeAcademique->id),],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
            'note_validation' => ['nullable', 'numeric', 'between:0,20'],
            'description' => ['nullable', 'string'],
            'est_active' => ['boolean'],
        ];
    }
}