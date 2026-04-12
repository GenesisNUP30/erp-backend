<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\WorkerRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Muestra la lista de trabajadores (usuarios no administradores).
     */
    public function index()
    {
        // Se intenta identificar al usuario del token de forma manual
        $userAutenticado = auth('sanctum')->user();

        // La Policy ya tiene el (?User $user), así que no fallará si es null
        $this->authorize('viewAny', User::class);

        // Iniciamos la consulta base
        $query = User::select('id', 'name', 'username', 'email', 'dni', 'telefono', 'rol', 'estado','fecha_alta', 'fecha_baja');

        // Si hay un usuario logueado, se filtran los trabajadores
        if ($userAutenticado) {
            // 1. No mostrarse a sí mismo
            $query->where('id', '!=', $userAutenticado->id);

            // Si es encargado, no puede ver a los administradores
            if ($userAutenticado->rol === 'encargado') {
                $query->where('rol', '!=', 'administrador');
            }
        } else {
            // Si no hay nadie logueado (modo profesor), ocultamos los admin por seguridad
            $query->where('rol', '!=', 'administrador');
        }

        $trabajadores = $query->get();

        return response()->json([
            'success' => true,
            'data' => $trabajadores,
            'count' => $trabajadores->count()
        ]);
    }

    /**
     * Permite crear un nuevo trabajador y validar los datos enviados.
     */
    public function store(WorkerRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['email_verified_at'] = now();

        $trabajador = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'El trabajador ha sido creado correctamente',
            'data' => $trabajador
        ], 201);
    }

    /**
     * Muestra los datos de un trabajador especificado por su id..
     */
    public function show(string $id)
    {
        // Buscamos al trabajador (solos los activos)
        $trabajador = User::findOrFail($id);

        $this->authorize('view', $trabajador);

        return response()->json([
            'success' => true,
            'data' => $trabajador
        ]);
    }

    /**
     * Edita un trabajador existente y valida los datos enviados.
     */
    public function update(WorkerRequest $request, string $id)
    {
        $trabajador = User::findOrFail($id);
        $this->authorize('update', $trabajador);

        $data = $request->validated();

        // Lógica de limpieza: Si el estado es activo, forzamos fecha_baja a null
        if ($data['estado'] === 'activo') {
            $data['fecha_baja'] = null;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $trabajador->update($data);

        return response()->json([
            'success' => true,
            'message' => 'El trabajador ha sido actualizado correctamente',
            'data' => $trabajador
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trabajador = User::findOrFail($id);
        $this->authorize('delete', $trabajador);

        $trabajador->delete();

        return response()->json([
            'success' => true,
            'message' => 'El trabajador ha sido eliminado correctamente'
        ]);
    }
}
