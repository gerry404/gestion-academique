<?php
// app/Http/Requests/UpdateEtudiantRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEtudiantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('etudiant');

        return [
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'sexe' => ['required', 'in:M,F'],
            'date_naissance' => ['nullable', 'date', 'before:today'],
            'lieu_naissance' => ['nullable', 'string', 'max:100'],
            'nationalite' => ['nullable', 'string', 'max:100'],
            'pays' => ['nullable', 'string', 'max:100'], // ✅ Ajouter
            'telephone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150', Rule::unique('etudiants')->ignore($id)],
            'adresse' => ['nullable', 'string'],
            'est_actif' => ['boolean'],
        ];
    }
}