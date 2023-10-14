<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;


class UsuarioController extends Controller
{
    
    public function register(Request $request){
        $validate =  Validator::make(
            $request->all(),
            [
                "name"                  => "required|max:100|min:4",
                "email"                   => "required",
                "password"             => "required|min:8"
            ]
        );

        if($validate->fails()){
            return response()->json([
                "msg" => "Error al validar los datos",
                "error" => $validate->errors()
        ], 422);
        }

        $usuario = new Usuario();
        $usuario ->name                     =   $request->name;
        $usuario->email                     = $request->email;
        $usuario->password              = $request->password;
        $usuario->role_id                    = 3;
        $usuario->save();
        $usuario->makeHidden('password');

        return response()->json([
            "msg" => "Usuario registrado exitosamente",
            "data" => $usuario        
        ], 201);
    }

}
