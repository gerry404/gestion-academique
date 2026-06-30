<?php
// app/Http/Requests/Etablissement/UpdatePersonnelRequest.php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonnelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('personnel');

        return [
            'matricule' => ['required', 'string', 'max:20', Rule::unique('personnels')->ignore($id)],
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'sexe' => ['required', 'in:M,F'],
            'date_naissance' => ['nullable', 'date', 'before:today'],
            'lieu_naissance' => ['nullable', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150', Rule::unique('personnels')->ignore($id)],
            'adresse' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:255'],
            'diplome' => ['nullable', 'string', 'max:255'],
            'fonction' => ['required', 'string', 'max:100'],
            'date_embauche' => ['nullable', 'date', 'before:today'],
            'est_actif' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'matricule.required' => 'Le matricule est obligatoire.',
            'matricule.unique' => 'Ce matricule existe déjà.',
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'sexe.required' => 'Le sexe est obligatoire.',
            'sexe.in' => 'Le sexe doit être M ou F.',
            'fonction.required' => 'La fonction est obligatoire.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'date_naissance.before' => 'La date de naissance doit être dans le passé.',
            'date_embauche.before' => 'La date d\'embauche doit être dans le passé.',
        ];
    }
}