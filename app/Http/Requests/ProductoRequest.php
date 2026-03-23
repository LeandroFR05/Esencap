<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'nombre' => 'required|sometimes|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048|dimensions:max_width=2000,max_height=2000',
            'fechaElaboracion' => 'bail|sometimes|required|date_format:Y-m-d',
        ];
    }



    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',

            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'Formato inválido (jpeg, png, jpg, gif, avif, webp).',
            'foto.max' => 'La imagen no debe superar los 2MB.',
            'foto.dimensions' => 'Máximo permitido: 2000x2000px.',

            'fechaElaboracion.required' => 'La fecha de vencimiento es obligatoria.',
            'fechaElaboracion.date' => 'La fecha de vencimiento no es válida.',
            'fechaElaboracion.date_format' => 'El formato de fecha de vencimiento debe ser DD-MM-YYYY.',
        ];
    }
}
