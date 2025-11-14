<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestSalesController extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cuit' => $this->route('cuit')  // ← Obtiene {cuit} de la URL
        ]);
    }
    public function rules(): array
    {
        return [
            'cuit' => ['required', 'integer', 'exists:clients,cuit'],
        ];
    }
}
