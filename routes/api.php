<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivationController;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function() {
    return response()->json([
        'message' => 'Felicidades',
        'message2' => 'conexion exitosa.'
        ], 200);
});

Route::post('/register', [UserController::class, 'register']); /**Ruta para registrar los usuarios */
Route::get('/activate-account/{userID}');/**Ruta para generar token */
Route::post('/login', [UserController::class, 'login'])->name('login');/**Ruta para el login */
Route::delete('/logout');/**Ruta para deshabilitar el token */
Route::get('/me', [UserController::class, 'me']);/**Ruta para traer la informacion del dueño del token */
Route::get('/activation/{user}', [ActivationController::class, 'activate'])->name('activation');/**Ruta para activar la cuenta del usuario */


