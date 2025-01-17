<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    // Método de registro
    public function register(Request $request)
    {
        // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Si la validación falla, devolverá errores
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false, // Por defecto es falso
            'is_banned' => false, // Por defecto es falso
        ]);

        // Evento de registro
        event(new Registered($user));

        // Retornar la respuesta con el token
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    // Método de login
    public function login(Request $request)
    {
        // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Si la validación falla, devolverá errores
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Verificar las credenciales
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Verificar si el usuario es admin
    if (!$user->is_admin) {
        return response()->json(['message' => 'Only admin can access'], 401);
    }
        // Crear un token para el usuario y retornarlo
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }
}
