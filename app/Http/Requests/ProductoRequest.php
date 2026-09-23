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

    protected function prepareForValidation(): void
    {
        $stockInicial = $this->input('stockInicial');
        $contenidoPorUnidad = $this->input('contenidoPorUnidad');

        if ($stockInicial !== null && $stockInicial !== '' && is_numeric($stockInicial)) {
            $this->merge([
                'stockInicial' => (int) $stockInicial,
            ]);
        }
        if ($contenidoPorUnidad !== null && $contenidoPorUnidad !== '' && is_numeric($contenidoPorUnidad)) {
            $this->merge([
                'contenidoPorUnidad' => $contenidoPorUnidad,
            ]);
        }
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
            'stockInicial' => 'required|sometimes|numeric|min:1|max:99999.99',
            'contenidoPorUnidad' => 'required|numeric|min:0.01|max:99999.99',
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

            'stockInicial.required' => 'El stock inicial es obligatorio.',
            'stockInicial.numeric' => 'El stock inicial debe ser un número.',
            'stockInicial.min' => 'El stock inicial debe ser mayor a cero.',
            'stockInicial.max' => 'El stock inicial no puede superar 99999.',

            'contenidoPorUnidad.required' => 'El contenido por unidad es obligatorio.',
            'contenidoPorUnidad.numeric' => 'El contenido por unidad debe ser un número.',
            'contenidoPorUnidad.min' => 'El contenido por unidad debe ser mayor a cero.',
            'contenidoPorUnidad.max' => 'El contenido por unidad no puede superar 999999,99.',

            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'Formato inválido.',
            'foto.max' => 'La imagen no debe superar los 2MB.',
            'foto.dimensions' => 'Tamaño máximo permitido: 2000x2000px.',

            'fechaElaboracion.required' => 'La fecha de elaboración es obligatoria.',
            'fechaElaboracion.date_format' => 'El formato de fecha debe ser dd/mm/aaaa.',
        ];
    }
}
