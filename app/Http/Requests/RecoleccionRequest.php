<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecoleccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cosecha_id' => 'required|exists:cosechas,id',
            'user_id'    => 'nullable|exists:users,id',
            'fecha'      => 'required|date',
            'num_cajas'  => 'required|integer|min:1',
            'kilos_caja' => 'required|numeric|min:0.01',
            'notas'      => 'nullable|string|max:500',
            'estado'     => 'required|in:registrada,verificada,anulada',
        ];
    }

    public function messages(): array
    {
        return [
            'cosecha_id.required' => 'La cosecha es obligatoria.',
            'cosecha_id.exists'   => 'La cosecha seleccionada no existe.',
            'num_cajas.min'       => 'El número de cajas debe ser al menos 1.',
            'kilos_caja.min'      => 'Los kilos por caja deben ser mayores a 0.',
            'estado.in'           => 'Estado no válido.',
        ];
    }
}
