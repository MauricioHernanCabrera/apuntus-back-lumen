<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller {
  public function loginWithToken (Request $request) {
    try {
      $data = $request->json()->all();
      $user = User::where('token_user', '=', $data['token_user'])->first();
      
      if ($user) {
        $user->makeVisible('token_user');
        return response()->json($user, 200);
      } else {
        return response()->json(['error' => '¡Recurso no encontrado!'], 404);
      }
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
    }
  }

  public function loginWithEmail (Request $request) {
    try {
    
      $data = $request->json()->all();
      $user = User::where('email', '=', $data['email'])->first();
      
      $passwordDecrypt = Crypt::decrypt($user->password);
      
      if (strcmp($passwordDecrypt, $data['password']) == 0) {
        if (!$user->token_user) {
          $user->update(['token_user' => Crypt::encrypt($data['email'] . $data['password'])]);
        }
        $user->makeVisible('token_user');
        return response()->json($user, 200);
      } else {
        return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
      }
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
    } catch (DecryptException $e) {
      return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
    }
  }

  public function loginWithUsername (Request $request) {
    try {
    
      $data = $request->json()->all();
      $user = User::where('username', '=', $data['username'])->first();
      
      $passwordDecrypt = Crypt::decrypt($user->password);
      
      if (strcmp($passwordDecrypt, $data['password']) == 0) {
        if (!$user->token_user) {
          $user->update(['token_user' => Crypt::encrypt($data['username'] . $data['password'])]);
        }
        $user->makeVisible('token_user');
        return response()->json($user, 200);
      } else {
        return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
      }
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
    } catch (DecryptException $e) {
      return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
    }
  }

  public function register (Request $request) {
    try {
      $data = $request->json()->all();
      $user = User::create([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => Crypt::encrypt($data['password']),
        'token_user' => Crypt::encrypt($data['email'] . $data['password'])
      ]);
      $user->makeVisible('token_user');
      return response()->json($user, 201);

    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => '¡Recursos proporcionados invalidos!'], 400);
    }
    
    return response()->json($institution, 201);
  }
}
