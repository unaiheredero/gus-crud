<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        return response()->json(User::all());
    }

    // Crear un nuevo usuario
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'is_admin' => 'required|boolean',
        'is_banned' => 'required|boolean',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'is_admin' => $request->is_admin,
        'is_banned' => $request->is_banned,
    ]);

    return response()->json($user, 201);
}


    // Mostrar un usuario específico
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'is_admin' => 'required|boolean',
        'is_banned' => 'required|boolean',
    ]);

    if ($request->has('name')) {
        $user->name = $request->name;
    }
    if ($request->has('email')) {
        $user->email = $request->email;
    }
    if ($request->has('password')) {
        $user->password = bcrypt($request->password);
    }
    if ($request->has('is_admin')) {
        $user->is_admin = $request->is_admin;
    }
    if ($request->has('is_banned')) {
        $user->is_banned = $request->is_banned;
    }

    $user->save();

    return response()->json($user);
}


    // Eliminar un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
