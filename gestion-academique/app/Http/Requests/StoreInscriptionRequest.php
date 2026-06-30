<?php
// app/Http/Requests/StoreInscriptionRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'etudiant_id' => ['required', 'exists:etudiants,id'],
            'annee_academique_id' => ['required', 'exists:annees_academiques,id'],
            'departement_id' => ['required', 'exists:departements,id'],
            'specialite_id' => ['required', 'exists:specialites,id'],
            'niveau_id' => ['required', 'exists:niveaux,id'],
            'statut' => ['nullable', 'in:en_attente,validee,annulee'],
            'commentaire' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'etudiant_id.required' => 'Veuillez sélectionner un étudiant.',
            'annee_academique_id.required' => 'Veuillez sélectionner une année académique.',
            'departement_id.required' => 'Veuillez sélectionner un département.',
            'specialite_id.required' => 'Veuillez sélectionner une spécialité.',
            'niveau_id.required' => 'Veuillez sélectionner un niveau.',
        ];
    }
}