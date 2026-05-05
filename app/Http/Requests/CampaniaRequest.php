<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaniaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPost = $this->isMethod('post');
        $campaniaId = $this->route('id');

        return [
            'nombre' => [
                'required', 'string', 'max:255',
                $isPost ? 'unique:campanias,nombre' : 'unique:campanias,nombre,' . $campaniaId
            ],
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|in:activa,finalizada,planificada',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la campaña es obligatorio.',
            'nombre.unique' => 'Ya existe una campaña con este nombre.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser activa, finalizada o planificada.',
        ];
    }
}