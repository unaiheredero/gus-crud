<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Obtener todos los usuarios
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'isAdmin' => 'required|boolean',
            'isBanned' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'passHash' => bcrypt($request->password), // Encriptar la contraseña
            'isAdmin' => (bool) $request->isAdmin, // Asegurar que sea booleano
            'isBanned' => (bool) $request->isBanned,
        ]);
        return response()->json($user, 201);
    }

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'isAdmin' => 'nullable|boolean',
        'isBanned' => 'nullable|boolean',
    ]);

    if ($request->filled('password')) {
        $user->passHash = bcrypt($request->password);
        $user->save(); // Guardar el cambio antes de actualizar otros datos
    }

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'isAdmin' => $request->has('isAdmin') ? (bool) $request->isAdmin : $user->isAdmin,
        'isBanned' => $request->has('isBanned') ? (bool) $request->isBanned : $user->isBanned,
    ]);

    return response()->json($user);
}




    // Eliminar un usuario
    public function destroy($id)
    {
        // Buscar el usuario por su ID
        $user = User::findOrFail($id);
        $user->delete();

        // Respuesta exitosa con código 204
        return response()->json(null, 204);
    }
}
