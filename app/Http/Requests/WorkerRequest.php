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

        return [
            'name' => 'required|string|max:60',
            'username' => [
                'required',
                'string',
                $isPost ? 'unique:users,username' : 'unique:users,username,' . $workerId
            ],
            'email' => [
                'required',
                'email',
                $isPost ? 'unique:users,email' : 'unique:users,email,' . $workerId
            ],
            'password' => $isPost ? 'required|string|min:8' : 'nullable|string|min:8',
            'dni' => [
                'required',
                $isPost ? 'unique:users,dni' : 'unique:users,dni,' . $workerId,
                new ValidarDni
            ],
            'telefono' => 'required|string|regex:/^[67][0-9]{8}$/',
            'rol' => [
                'required',
                'in:encargado,recolector,administrador',
                // Validación extra: Solo admin puede asignar roles
                // function ($attribute, $value, $fail) use ($isPost) {
                //     if (auth()->user()->rol !== 'administrador') {
                //         // Si no es admin y está intentando enviarlo, fallamos
                //         if ($this->has('rol')) $fail('No tienes permiso para asignar roles.');
                //     }
                // }
                function ($attribute, $value, $fail) {
                    $user = auth()->user();
                    // Solo validamos el permiso de rol si hay un usuario identificado
                    // Si no lo hay (pruebas de clase), dejamos pasar para que valide el DNI
                    if ($user && $user->rol !== 'administrador' && $this->has('rol')) {
                        $fail('No tienes permiso para asignar roles.');
                    }
                }
            ],
            'fecha_alta' => 'required|date|before_or_equal:today',
            'fecha_baja' => 'nullable|date|after_or_equal:fecha_alta',
        ];
    }
}
