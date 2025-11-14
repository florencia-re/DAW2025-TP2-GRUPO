<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Requisito obligatorio: email, name
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email'],
            'password' => ['required', 'numeric', 'digits_between:8,20'],
            'role' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección de correo válida.',
            'email.unique' => 'Ya existe un cliente con este email.',
            'password.numeric' => 'Debes ingresar solo datos numericos',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'password.digits_between' => 'La contraseña debe tener entre 8 y 20 dígitos.',
            'role.max' => 'El rol no debe exceder los 500 caracteres.',
            'role.nullable' => 'El rol puede estar vacío.'
        ];
    }
}
