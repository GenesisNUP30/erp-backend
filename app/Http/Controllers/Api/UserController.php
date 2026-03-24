<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra la lista de trabajadores (usuarios no administradores).
     */
    public function index()
    {
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|required|string|max:60',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'dni' => 'required|string|unique:users,dni|regex:/^[0-9]{8}[A-Z]$/',
            'telefono' => 'required|string|regex:/^[67][0-9]{8}$/',
            'rol' => 'required|in:encargado,recolector,administrador',
            'fecha_alta' => 'required|date|before_or_equal:today',
        ]);

        $trabajador = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'rol' => $request->rol,
            'fecha_alta' => $request->fecha_alta,
            'fecha_baja' => $request->fecha_baja ?? null,
        ]);

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
        $trabajador = User::where('rol', '!=', 'administrador')
            ->where('id', $id)
            ->select('id', 'name', 'username', 'dni', 'telefono', 'rol', 'fecha_alta', 'fecha_baja')
            ->first();

        if (!$trabajador) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el trabajador solicitado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $trabajador
        ]);
    }

    /**
     * Edita un trabajador existente y valida los datos enviados.
     */
    public function update(Request $request, string $id)
    {
        $trabajador = User::where('rol', '!=', 'administrador')
            ->where('id', $id)
            ->first();

        if (!$trabajador) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el trabajador solicitado'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:60',
            'username' => 'sometimes|required|string|unique:users,username,' . $id,
            'email' => 'sometimes|nullable|email|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|string|min:8',
            'dni' => 'sometimes|string|unique:users,dni,' . $id . '|regex:/^[0-9]{8}[A-Z]$/',
            'telefono' => 'sometimes|string|regex:/^[67][0-9]{8}$/',
            'rol' => 'sometimes|required|in:encargado,recolector,administrador',
            'fecha_alta' => 'sometimes|required|date|before_or_equal:today',
            'fecha_baja' => 'nullable|date|after_or_equal:fecha_alta',
        ]);

        // Actualización de campos
        $data = $request->only(['name', 'username', 'email', 'dni', 'telefono', 'rol', 'fecha_alta', 'fecha_baja']);

        // Si se proporciona nueva contraseña
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
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
        $trabajador = User::where('rol', '!=', 'administrador')
            ->where('id', $id)
            ->first();

        if (!$trabajador) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el trabajador solicitado'
            ], 404);
        }

        $trabajador->delete();

        return response()->json([
            'success' => true,
            'message' => 'El trabajador ha sido eliminado correctamente'
        ]);
    }
}
