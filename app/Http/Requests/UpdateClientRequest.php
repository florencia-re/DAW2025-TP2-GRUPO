<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        // Obtener el ID del cliente de la ruta
        $clientId = $this->route('client');

        return [

            'name' => ['required', 'string', 'max:255'],
            'cuit' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('clients', 'email')->ignore($clientId)],
            'phone' => ['required', 'numeric', 'digits_between:8,20'],
            'address' => ['nullable', 'string', 'max:500'],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'cuit.required' => 'El cuit es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección de correo válida.',
            'email.unique' => 'Ya existe un cliente con este email.',
            'phone.numeric' => 'Debes ingresar solo datos numericos en el campo Telefono',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
        ];
    }
}
