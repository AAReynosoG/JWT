<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

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

Route::post('/register', [UsuarioController::class, 'register']); /**Ruta para registrar los usuarios */
Route::get('/activate-account/{userID}');/**Ruta para generar token */
Route::post('/login');/**Ruta para el login */
Route::delete('/logout');/**Ruta para deshabilitar el token */
Route::get('/user/{userID}');/**Ruta para traer la informacion del dueño del token */