<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller {

  /**
   * Store a new user.
   *
   * @param  Request  $request
   * @return Response
   */
  public function register (Request $request) {
    $this->validate($request, [
      'username' => 'required|string|unique:users',
      'password' => 'required|confirmed',
    ]);

    try {
      $user = new User;
      $user->name = $request->get('name');
      $user->username = $request->get('username');
      $user->email = $request->get('email');
      $user->address = $request->get('address');
      $user->password = app('hash')->make($request->get('password'));
      $user->save();

      return response()->json([
        'status' => true,
        'message' => $user
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => 'Error found : ' . $e
      ]);
    }
  }

  /**
   * Get a JWT via given credentials.
   *
   * @param  Request  $request
   * @return Response
   */
  public function login (Request $request) { 
    $this->validate($request, [
      'username' => 'required|string',
      'password' => 'required|string',
    ]);

    $credentials = $request->only(['username', 'password']);

    if (!$token = Auth::attempt($credentials)) {			
      return response()->json([
        'status' => false,
        'message' => 'Unauthorized'
      ]);
    }
    
    $token = Auth::attempt($credentials, ['exp' => Carbon::now()->addDays(1)->timestamp]);
    return $this->respondWithToken($token, Auth::user());
  }

  /**
   * Get user details.
   *
   * @param  Request  $request
   * @return Response
   */	 	
  public function me () {
    return response()->json(auth()->user());
  }

}