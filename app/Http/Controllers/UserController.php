<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Iilluminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AcountActivation;
use App\Models\User;

class UserController extends Controller
{

    public function __construct(){//Aqui se especifica que metodos necesitan autenticacion
        $this->middleware('auth:api', ['except' => ['register', 'login']]); //Aqui se especifica que metodos no necesitan autenticacion
    }

    public function login(){
        $credentials = request(['email', 'password']);//Aqui se obtienen las credenciales del usuario

        if(! $token = auth()->attempt($credentials)){//Aqui se verifica si las credenciales son correctas
            return response()->json([
                'msg' => 'No autorizado'
            ], 401);
        }

        return $this->respondWithToken($token);//Aqui se genera el token
    }

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

        $user = new User();
        $user ->name                     =   $request->name;
        $user->email                     = $request->email;
        $user->password              =  Hash::make ($request->password);
        $user->role_id                    = 3;
        $user->save();
        $user->makeHidden('password');

        Mail::to($user->email)->send(new AcountActivation($user));//Aqui se envia el correo de activacion

        return response()->json([
            "msg" => "Usuario registrado exitosamente",
            "data" => $user
        ], 201);
    }


    public function me(){
        return response()->json(auth()->user());//Aqui se obtiene la informacion del usuario
    }


    public function logout(){
        auth()->logout(true);//Aqui se deshabilita el token

        return response()->json([
            'msg' => 'Sesion cerrada exitosamente'
        ]);
    }


    public function refresh(){//Aqui se refresca el token
        return $this->respondWithToken(auth()->refresh());//Aqui se refresca el token
    }


    protected  function respondWithToken($token){//Aqui se genera el token
        return response()->json([
            'access_token' => $token,//Aqui se especifica el token
            'token_type' => 'bearer',//Aqui se especifica el tipo de token
            'expires_in' => auth()->factory()->getTTL() * 60//Aqui se especifica el tiempo de expiracion del token
        ]);
    }

}
