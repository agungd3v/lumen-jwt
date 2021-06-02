<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController {

  public function respondWithToken ($token, $user) {
    return response()->json([
      'user' => $user,
      'token' => $token,
      'expires_in' => '1 Day'
    ]);
  }

}
