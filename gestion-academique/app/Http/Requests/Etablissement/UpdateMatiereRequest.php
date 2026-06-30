<?php
// app/Http/Requests/Etablissement/UpdateMatiereRequest.php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Etablissement\UniteEnseignement;

class UpdateMatiereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('matiere');

        return [
            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('matieres', 'code')->ignore($id),
            ],
            'libelle' => [
                'required',
                'string',
                'max:150',
            ],
            'credit' => [
                'required',
                'integer',
                'min:1',
                'max:60',
            ],
            'departement_id' => [
                'required',
                'exists:departements,id',
                Rule::exists('departements', 'id')
                    ->where(function ($query) {
                        $query->where('est_actif', true);
                    }),
            ],
            'unite_enseignement_id' => [
                'required',
                'exists:unites_enseignement,id',
            ],
            'semestre_id' => [
                'required',
                'exists:semestres,id',
            ],
            'niveau_id' => [
                'required',
                'exists:niveaux,id',
                Rule::exists('niveaux', 'id')
                    ->where(function ($query) {
                        $query->where('est_actif', true);
                    }),
            ],
            'personnel_id' => [
                'nullable',
                'exists:personnels,id',
                Rule::exists('personnels', 'id')
                    ->where(function ($query) {
                        $query->where('est_actif', true);
                    }),
            ],
            'est_actif' => [
                'boolean',
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Vérifier que la somme des crédits ne dépasse pas le total_credit de l'UE
            $ue = UniteEnseignement::find($this->unite_enseignement_id);
            if ($ue) {
                $totalCreditsMatiere = \App\Models\Etablissement\Matiere::where('unite_enseignement_id', $this->unite_enseignement_id)
                    ->where('id', '!=', $this->route('matiere'))
                    ->sum('credit');
                
                $nouveauTotal = $totalCreditsMatiere + $this->credit;
                
                if ($nouveauTotal > $ue->total_credit) {
                    $validator->errors()->add(
                        'credit',
                        "Le total des crédits des matières ({$nouveauTotal}) dépasse le crédit total de l'UE ({$ue->total_credit})."
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Le code est obligatoire.',
            'code.unique' => 'Ce code de matière existe déjà.',
            'libelle.required' => 'Le libellé est obligatoire.',
            'credit.required' => 'Le crédit est obligatoire.',
            'credit.min' => 'Le crédit doit être au moins 1.',
            'credit.max' => 'Le crédit ne peut pas dépasser 60.',
            'departement_id.required' => 'Le département est obligatoire.',
            'departement_id.exists' => 'Veuillez sélectionner un département actif.',
            'unite_enseignement_id.required' => 'L\'UE est obligatoire.',
            'unite_enseignement_id.exists' => 'Veuillez sélectionner une UE valide.',
            'semestre_id.required' => 'Le semestre est obligatoire.',
            'semestre_id.exists' => 'Veuillez sélectionner un semestre valide.',
            'niveau_id.required' => 'Le niveau est obligatoire.',
            'niveau_id.exists' => 'Veuillez sélectionner un niveau actif.',
            'personnel_id.exists' => 'Veuillez sélectionner un personnel actif.',
        ];
    }
}