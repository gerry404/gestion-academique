<?php
// app/Http/Requests/Etablissement/UpdateSemestreRequest.php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSemestreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('semestre');

        return [
            'libelle' => [
                'required',
                'string',
                'max:30',
                // ✅ Ajouter niveau_id dans la contrainte d'unicité
                Rule::unique('semestres', 'libelle')
                    ->where('annee_academique_id', $this->annee_academique_id)
                    ->where('niveau_id', $this->niveau_id)
                    ->ignore($id),
            ],
            'annee_academique_id' => [
                'required',
                'exists:annees_academiques,id',
                Rule::exists('annees_academiques', 'id')
                    ->where(function ($query) {
                        $query->where('est_active', true);
                    }),
            ],
            'niveau_id' => [
                'required',
                'exists:niveaux,id',
                Rule::exists('niveaux', 'id')
                    ->where(function ($query) {
                        $query->where('est_actif', true);
                    }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.unique' => 'Ce semestre existe déjà pour ce niveau et cette année académique.',
            'annee_academique_id.required' => 'L\'année académique est obligatoire.',
            'annee_academique_id.exists' => 'Veuillez sélectionner une année académique active.',
            'niveau_id.required' => 'Le niveau est obligatoire.',
            'niveau_id.exists' => 'Veuillez sélectionner un niveau actif.',
        ];
    }
}