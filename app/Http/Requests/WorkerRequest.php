<?php

namespace App\Http\Requests;

use App\Rules\ValidarDni;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class WorkerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // La autorización se maneja en la Policy
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isPost = $this->isMethod('post');
        $workerId = $this->route('trabajadore');
        $userAutenticado = auth('sanctum')->user();

        return [
            // Campos obligatorios siempre
            'name' => 'required|string|max:60',
            'dni' => [
                'required',
                $isPost ? 'unique:users,dni' : 'unique:users,dni,' . $workerId,
                new ValidarDni
            ],
            'telefono' => 'required|string|regex:/^[67][0-9]{8}$/',
            'fecha_alta' => 'required|date|before_or_equal:today',

            // Campos opcionales con lógica y validación si se envían
            'username' => [
                'required_without:email', // Obligatorio si no hay email
                'nullable',
                'string',
                $isPost ? 'unique:users,username' : 'unique:users,username,' . $workerId
            ],
            'email' => [
                'required_without:username', // Obligatorio si no hay username
                'nullable',
                'email',
                $isPost ? 'unique:users,email' : 'unique:users,email,' . $workerId
            ],
            // CONTRASEÑA (Obligatoria en creación, opcional en edición)
            'password' => $isPost ? 'required|string|min:8' : 'nullable|string|min:8',
            'rol' => [
                'required',
                'in:encargado,recolector,administrador',
                function ($attribute, $value, $fail) use ($userAutenticado, $workerId, $isPost) {
                    if (!$userAutenticado) return; // Saltamos para el profesor

                    // Solo el admin puede CREAR (ya lo filtra la Policy)
                    if ($isPost && $userAutenticado->rol !== 'administrador') {
                        $fail('Solo el administrador puede crear nuevos trabajadores.');
                    }

                    // En EDICIÓN: El encargado no puede cambiar el rol
                    if (!$isPost && $userAutenticado->rol === 'encargado') {
                        $originalWorker = \App\Models\User::find($workerId);
                        if ($originalWorker && $value !== $originalWorker->rol) {
                            $fail('Como encargado, no tienes permiso para modificar el rango de los trabajadores.');
                        }
                    }
                }
            ],
            'fecha_baja' => 'nullable|date|after_or_equal:fecha_alta',
        ];
    }

    public function messages()
    {
        return [
            'username.required_without' => 'Debes rellenar el nombre de usuario si el email está vacío.',
            'email.required_without' => 'Debes rellenar el email si el nombre de usuario está vacío.',
            'dni.required' => 'El DNI es obligatorio.',
            'name.required' => 'El nombre completo es obligatorio.',
        ];
    }
}
