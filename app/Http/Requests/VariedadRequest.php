<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariedadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPost = $this->isMethod('post');
        $variedadId = $this->route('id');

        return [
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:remontante, no_remontante',
            'descripcion' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser remontante o no remontante.',
            'descripcion.max' => 'La descripción no puede tener más de 255 caracteres.',
        ];
    }
}