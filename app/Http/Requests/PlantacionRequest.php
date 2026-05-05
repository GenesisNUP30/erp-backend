<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPost = $this->isMethod('post');
        $plantacionId = $this->route('id');

        return [
            'parcela_id'     => 'required|exists:parcelas,id',
            'variedad_id'    => 'required|exists:variedades,id',
            'campania_id'    => 'required|exists:campanias,id',
            'fecha_siembra' => 'required|date',
            'numero_plantas' => 'required|numeric|min:1',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_siembra',
            'estado' => 'required|in:planificada,activa,finalizada',
        ];
    }

    public function messages(): array
    {
        return [
            'parcela_id.exists'  => 'La parcela seleccionada no es válida.',
            'variedad_id.exists' => 'La variedad seleccionada no es válida.',
            'campania_id.exists' => 'La campaña seleccionada no es válida.',
            'fecha_siembra.required' => 'La fecha de siembra es obligatoria.',
            'numero_plantas.required' => 'El número de plantas es obligatorio.',
            'numero_plantas.min' => 'El número de plantas debe ser al menos 1.',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser posterior o igual a la fecha de siembra.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser planificada, activa o finalizada.',
        ];
    }
}