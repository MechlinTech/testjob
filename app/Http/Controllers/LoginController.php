<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
  public function login(Request $request)
  {
    $credentials = [
      'email' => $request->email,
      'password' => $request->password
    ];
    if (auth()->attempt($credentials)) {
      $token = auth()->user()->createToken('Mechlin')->accessToken;
      return response()->json(['token' => $token], 200);
    } else {
      return response()->json(['error' => 'UnAuthorised'], 401);
    }
  }


  public function details()
  {
    return response()->json(['user' => auth()->user()], 200);
  }
}
