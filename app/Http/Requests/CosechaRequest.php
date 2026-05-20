<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CosechaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plantacion_id'  => 'required|exists:plantaciones,id',
            'campania_id'    => 'required|exists:campanias,id',
            'nombre_cosecha' => 'required|string|max:255',
            'fecha_inicio'   => 'required|date',
            'fecha_fin'      => 'nullable|date|after_or_equal:fecha_inicio',
            'estado'         => 'required|in:en_crecimiento,en_recoleccion,en_poda,finalizada',
        ];
    }

    public function messages(): array
    {
        return [
            'plantacion_id.required' => 'La plantación es obligatoria.',
            'plantacion_id.exists'   => 'La plantación seleccionada no existe.',
            'campania_id.exists'     => 'La campaña seleccionada no existe.',
            'nombre_cosecha.required' => 'El nombre de la cosecha es obligatorio.',
            'fecha_inicio.required'  => 'La fecha de inicio es obligatoria.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior a la de inicio.',
            'estado.in'              => 'Estado no válido.',
        ];
    }
}
