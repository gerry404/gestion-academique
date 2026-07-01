<?php
// app/Http/Requests/Notes/UpdateNoteRequest.php

namespace App\Http\Requests\Notes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'note_cc' => ['required', 'numeric', 'min:0', 'max:20'],
            'note_examen' => ['required', 'numeric', 'min:0', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'note_cc.required' => 'La note de contrôle continu est obligatoire.',
            'note_cc.min' => 'La note de CC doit être au moins 0.',
            'note_cc.max' => 'La note de CC ne peut pas dépasser 20.',
            'note_examen.required' => 'La note d\'examen est obligatoire.',
            'note_examen.min' => 'La note d\'examen doit être au moins 0.',
            'note_examen.max' => 'La note d\'examen ne peut pas dépasser 20.',
        ];
    }
}