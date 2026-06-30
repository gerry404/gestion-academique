<?php
// app/Http/Requests/Etablissement/StoreDepartementRequest.php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:departements,code'],
            'libelle' => ['required', 'string', 'max:100', 'unique:departements,libelle'],
            'description' => ['nullable', 'string'],
            'chef_departement_id' => [
                'nullable',
                Rule::exists('personnels', 'id')
                    ->where(function ($query) {
                        $query->where('est_actif', true);
                    }),
            ],        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Le code est obligatoire.',
            'code.unique' => 'Ce code de département existe déjà.',
            'libelle.required' => 'Le libellé est obligatoire.',
            'chef_departement_id.exists' => 'Le chef de département sélectionné n\'existe pas.',
        ];
    }
}