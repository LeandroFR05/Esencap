<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsumoRequest extends FormRequest
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif,webp|max:2048|dimensions:max_width=2000,max_height=2000',
            'fase' => 'required|sometimes|string|max:10',
            'idFamilia' => 'required|sometimes|exists:familias,idFamilia',
            'stockInicial' => 'required|sometimes|numeric|max:999999.99',
            'fechaCompra' => 'bail|sometimes|required|date_format:Y-m-d|before_or_equal:today',
            'fechaVencimiento' => 'bail|sometimes|required|date_format:Y-m-d',
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
            'foto.dimensions' => 'Dimensión máxima permitida para la imagen: 2000x2000.',

            'fase.required' => 'La fase es obligatoria.',
            'fase.string' => 'La fase debe ser texto.',
            'fase.max' => 'Máximo 10 caracteres.',

            'idFamilia.required' => 'Debe seleccionar una familia.',
            'idFamilia.exists' => 'La familia seleccionada no es válida.',

            'stockInicial.max' => 'El stock inicial no puede superar 999999,99.',

            'fechaCompra.required' => 'La fecha de compra es obligatoria.',
            'fechaCompra.date' => 'La fecha de compra no es válida.',
            'fechaCompra.date_format' => 'El formato de fecha de compra debe ser DD-MM-YYYY.',
            'fechaCompra.before_or_equal' => 'La fecha de compra no puede ser futura.',

            'fechaVencimiento.required' => 'La fecha de vencimiento es obligatoria.',
            'fechaVencimiento.date' => 'La fecha de vencimiento no es válida.',
            'fechaVencimiento.date_format' => 'El formato de fecha de vencimiento debe ser DD-MM-YYYY.',
        ];
    }

}
