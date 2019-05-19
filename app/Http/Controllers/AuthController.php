<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller {
  public function loginWithToken (Request $request) {
    $token_user = $request->header('token_user');
    // return response()->json($token_user, 200);
    $user = User::where('token_user', $token_user)->firstOrFail();
    $user->makeVisible('token_user');
    return response()->json($user, 200);
  }

  public function loginWithEmail (Request $request) {
    try {
    
      $data = $request->json()->all();
      $user = User::where('email', $data['email'])->firstOrFail();
      
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
      
    } catch (DecryptException $e) {
      return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
    }
  }

  public function loginWithUsername (Request $request) {
    try {
    
      $data = $request->json()->all();
      $user = User::where('username', '=', $data['username'])->firstOrFail();
      
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
    } catch (DecryptException $e) {
      return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
    }
  }

  public function register (Request $request) {
    $this->validate($request, [
      'username' => 'required|regex:/^[a-zA-Z0-9\-\ñ\Ñ\.\_]+$/|unique:users,username|max:60',
      'email' => 'required|email|unique:users,email|max:100',
      'password' => 'required|max:200',
    ]);

    $data = $request->json()->all();

    $user = User::create([
      'username' => $data['username'],
      'email' => $data['email'],
      'password' => Crypt::encrypt($data['password']),
      'token_user' => Crypt::encrypt($data['email'] . $data['password'])
    ]);

    $user->makeVisible('token_user');
    return response()->json($user, 201);
  }

  public function sendEmailResetPassword (Request $request) {
    return response()->json($user, 201);
  }

  public function resetPassword (Request $request) {
    return response()->json($user, 201);
  }
}
