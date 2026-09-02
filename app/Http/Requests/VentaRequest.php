<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
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
            'idProducto' => 'required|sometimes|exists:productos,idProducto',
            'cliente' => 'required|sometimes|string|max:50',
            'cantidad' => 'required|integer|min:1',
            'fecha' => 'bail|sometimes|required|date_format:Y-m-d',
        ];
    }


    public function messages(): array
    {
        return [
            'cliente.required' => 'El cliente es obligatorio.',
            'cliente.string' => 'El nombre del cliente debe ser texto.',
            'cliente.max' => 'El nombre del cliente no puede tener más de 50 caracteres.',

            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'fecha.date_format' => 'El formato de fecha debe ser DD/MM/YYYY.',
        ];
    }
}
