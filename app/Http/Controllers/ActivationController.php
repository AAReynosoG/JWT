<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ActivationController extends Controller
{
    public function activate(Request $request,User $user){
      if(!$request->hasValidSignature()){
        return response()->json([
          "msg" => "Enlace de activacion invalido"
        ], 401);

      }

      $user->is_active = true;
      $user->save();

      return redirect('/');
    }
}
