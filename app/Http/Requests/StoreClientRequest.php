<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Generalmente, si el usuario está autenticado, tiene permiso.
        // Las Policies de Laravel pueden manejar restricciones más finas.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // Requisito obligatorio: email, name
            'name' => ['required', 'string', 'max:255'],
            'cuit' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email'],
            'phone' => ['required', 'numeric', 'digits_between:8,20'],
            'address' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'cuit.required' => 'El cuit es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección de correo válida.',
            'email.unique' => 'Ya existe un cliente con este email.',
            'phone.numeric' => 'Debes ingresar solo datos numericos',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
        ];
    }
}
