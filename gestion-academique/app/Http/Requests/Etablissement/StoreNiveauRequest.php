<?php
// app/Http/Requests/Etablissement/StoreNiveauRequest.php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNiveauRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'libelle' => [
                'required',
                'string',
                'max:20',
                Rule::unique('niveaux', 'libelle')
                    ->where('specialite_id', $this->specialite_id)
                    ->where('annee_academique_id', $this->annee_academique_id),
            ],
            'departement_id' => [
                'required',
                'exists:departements,id',
                Rule::exists('departements', 'id')
                    ->where(function ($query) {
                        $query->where('est_actif', true);
                    }),
            ],
            'specialite_id' => [
                'required',
                'exists:specialites,id',
                Rule::exists('specialites', 'id')
                    ->where(function ($query) {
                        $query->where('est_actif', true);
                    }),
                // ✅ Vérifier que la spécialité appartient bien au département sélectionné
                function ($attribute, $value, $fail) {
                    $specialite = \App\Models\Etablissement\Specialite::find($value);
                    if ($specialite && $specialite->departement_id != $this->departement_id) {
                        $fail('La spécialité sélectionnée n\'appartient pas au département choisi.');
                    }
                },
            ],
            'annee_academique_id' => [
                'required',
                'exists:annees_academiques,id',
                Rule::exists('annees_academiques', 'id')
                    ->where(function ($query) {
                        $query->where('est_active', true);
                    }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.unique' => 'Ce niveau existe déjà pour cette spécialité et cette année.',
            'departement_id.required' => 'Le département est obligatoire.',
            'departement_id.exists' => 'Veuillez sélectionner un département actif.',
            'specialite_id.required' => 'La spécialité est obligatoire.',
            'specialite_id.exists' => 'Veuillez sélectionner une spécialité active.',
            'annee_academique_id.required' => 'L\'année académique est obligatoire.',
            'annee_academique_id.exists' => 'Veuillez sélectionner une année académique active.',
        ];
    }
}