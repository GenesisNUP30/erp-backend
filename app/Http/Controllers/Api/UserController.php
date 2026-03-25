<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\WorkerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra la lista de trabajadores (usuarios no administradores).
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $trabajadores = User::where('rol', '!=', 'administrador')
            ->select('id', 'name', 'username', 'dni', 'telefono', 'rol', 'fecha_alta', 'fecha_baja')
            ->get();

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
