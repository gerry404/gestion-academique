<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('utilisateur');

        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($user),
            ],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:admin,responsable,enseignant'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => "L'email est obligatoire.",
            'email.email' => "L'email n'est pas valide.",
            'email.unique' => 'Cet email est deja utilise.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caracteres.',
            'role.required' => 'Le role est obligatoire.',
            'role.in' => 'Le role est invalide.',
        ];
    }
}
