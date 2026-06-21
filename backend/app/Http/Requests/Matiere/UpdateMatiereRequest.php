<?php

namespace App\Http\Requests\Matiere;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMatiereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $matiere = $this->route('matiere');

        return [
            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('matieres', 'code')->ignore($matiere),
            ],
            'libelle' => ['required', 'string', 'max:150'],
            'coefficient' => ['required', 'integer', 'min:1', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Le code est obligatoire.',
            'code.unique' => 'Ce code existe deja.',
            'libelle.required' => 'Le libelle est obligatoire.',
            'coefficient.required' => 'Le coefficient est obligatoire.',
        ];
    }
}
