<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $loginValue = $request->input('login');

        $fieldType = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $loginValue)->first();

        // Comprobar si el usuario existe y la contraseña es correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Las credenciales son incorrectas.'
            ], 401);
        }

        // Comprobar si el usuario está de baja
        if ($user->fecha_baja !== null) {
            return response()->json([
                'message' => 'Este usuario ya no tiene acceso al sistema.'
            ], 403);
        }

        // Generacion de token stateless
        $token = $user->createToken('access_token')->plainTextToken;

        // Devolver la respuesta con el token y datos básicos del usuario
        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'rol' => $user->rol,
                    'fecha_alta' => $user->fecha_alta,
                ],
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.'
        ]);
    }
}
