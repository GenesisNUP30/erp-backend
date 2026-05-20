<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorasTrabajadaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'      => 'required|exists:users,id',
            'cosecha_id'   => 'required|exists:cosechas,id',
            'pago_id'      => 'nullable|exists:pagos,id',
            'fecha'        => 'required|date',
            'horas'        => 'required|numeric|min:0.25|max:24',
            'precio_hora'  => 'required|numeric|min:0',
            'tipo_trabajo' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'     => 'El trabajador es obligatorio.',
            'user_id.exists'       => 'El trabajador seleccionado no existe.',
            'cosecha_id.required'  => 'La cosecha es obligatoria.',
            'cosecha_id.exists'    => 'La cosecha seleccionada no existe.',
            'horas.min'            => 'El mínimo es 0.25 horas (15 minutos).',
            'horas.max'            => 'No se pueden registrar más de 24 horas en un día.',
            'precio_hora.required' => 'El precio por hora es obligatorio.',
            'tipo_trabajo.required' => 'El tipo de trabajo es obligatorio.',
        ];
    }
}
