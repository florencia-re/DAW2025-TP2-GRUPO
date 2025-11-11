<?php

namespace App\Http\Requests; 
// Define el espacio de nombres donde vive esta clase (dentro de app/Http/Requests)

use Illuminate\Foundation\Http\FormRequest;
// Importa la clase base que Laravel usa para crear solicitudes personalizadas con validaciones

class UserRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     * En este caso devuelve true, lo que significa que cualquiera puede usar este request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación que se aplican cuando se envía el formulario.
     */
    public function rules(): array
    {
        return [
            // 'name' es obligatorio y debe tener al menos 3 caracteres
            'name' => 'required|string|min:3|max:100',

            // 'email' es obligatorio, debe tener formato de email y ser único en la tabla users
            'email' => 'required|email|unique:users,email,' . $this->id,

            // 'password' es obligatorio al crear, debe tener mínimo 6 caracteres
            // en edición puede ser opcional (por eso a veces se usa 'nullable')
            'password' => $this->isMethod('post') 
                ? 'required|string|min:6'
                : 'nullable|string|min:6',
        ];
    }

    /**
     * Mensajes personalizados para mostrar si las reglas no se cumplen.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'El correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }
}

/* Este archivo define qué datos se validan al crear o editar un usuario y
 qué mensajes se muestran si hay errores.
Laravel lo ejecuta automáticamente cuando usás UserRequest en tu UserController.*/