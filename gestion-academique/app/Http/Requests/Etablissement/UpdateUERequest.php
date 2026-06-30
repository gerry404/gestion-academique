<?php
// app/Http/Requests/Etablissement/UpdateUERequest.php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUERequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('ue');

        return [
            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('unites_enseignement', 'code')->ignore($id),
            ],
            'libelle' => [
                'required',
                'string',
                'max:150',
            ],
            'total_credit' => [
                'required',
                'integer',
                'min:1',
                'max:60',
            ],
            'position_releve' => [
                'nullable',
                'integer',
                'min:1',
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
            'code.required' => 'Le code est obligatoire.',
            'code.unique' => 'Ce code d\'UE existe déjà.',
            'libelle.required' => 'Le libellé est obligatoire.',
            'total_credit.required' => 'Le total de crédits est obligatoire.',
            'total_credit.min' => 'Le total de crédits doit être au moins 1.',
            'total_credit.max' => 'Le total de crédits ne peut pas dépasser 60.',
            'annee_academique_id.required' => 'L\'année académique est obligatoire.',
            'annee_academique_id.exists' => 'Veuillez sélectionner une année académique active.',
            'niveau_id.required' => 'Le niveau est obligatoire.',
            'niveau_id.exists' => 'Veuillez sélectionner un niveau actif.',
        ];
    }
}