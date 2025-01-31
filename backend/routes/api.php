<?php
use App\Http\Controllers\AuthController;
// routes/api.php
Route::post('login', [AuthController::class, 'login']);

use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);
