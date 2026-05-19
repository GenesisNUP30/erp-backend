<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'     => 'required|exists:users,id',
            'mes'         => 'required|integer|min:1|max:12',
            'anio'        => 'required|integer|min:2020',
            'total_horas' => 'required|numeric|min:0',
            'monto_total' => 'required|numeric|min:0',
            'estado'      => 'required|in:borrador,validado,pagado,archivado',
            'fecha_pago'  => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'     => 'El trabajador es obligatorio.',
            'mes.required'         => 'El mes es obligatorio.',
            'mes.between'          => 'El mes debe estar entre 1 y 12.',
            'anio.required'        => 'El año es obligatorio.',
            'total_horas.required' => 'El total de horas es obligatorio.',
            'monto_total.required' => 'El monto total es obligatorio.',
            'estado.in'            => 'Estado no válido.',
        ];
    }
}
