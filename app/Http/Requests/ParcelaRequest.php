<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParcelaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPost = $this->isMethod('post');
        $parcelaId = $this->route('id');

        return [
            'nombre' => [
                'required', 'string', 'max:255',
                $isPost ? 'unique:parcelas,nombre' : 'unique:parcelas,nombre,' . $parcelaId
            ],
            'superficie_hectareas' => 'required|numeric|min:0',
            'ubicacion' => 'required|string|max:255',
            'estado' => 'required|in:activa,inactiva,en_mantenimiento',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la parcela es obligatorio.',
            'nombre.unique' => 'Ya existe una parcela con este nombre.',
            'superficie_hectareas.required' => 'La superficie es obligatoria.',
            'superficie_hectareas.numeric' => 'La superficie debe ser un número.',
            'superficie_hectareas.min' => 'La superficie no puede ser negativa.',
            'ubicacion.required' => 'La ubicación es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser activa, inactiva o en_mantenimiento.',
        ];
    }
}