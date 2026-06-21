<?php

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'etudiant_id' => ['required', 'exists:etudiants,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'type' => ['required', 'in:CC,SN'],
            'valeur' => ['required', 'numeric', 'min:0', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'etudiant_id.required' => "L'etudiant est obligatoire.",
            'matiere_id.required' => 'La matiere est obligatoire.',
            'type.required' => 'Le type est obligatoire.',
            'type.in' => 'Le type doit etre CC ou SN.',
            'valeur.required' => 'La note est obligatoire.',
            'valeur.max' => 'La note doit etre entre 0 et 20.',
            'valeur.min' => 'La note doit etre entre 0 et 20.',
        ];
    }
}
