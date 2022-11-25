<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use STS\JWT\JWTFacade as JWT;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        //get request cookies
        $password = $request->password;
        
        //check if password is correct
        if ($password == env('APP_PASSWORD')) {
            $jwt = $this->makeJWT();
            return response()->json(['jwt' => $jwt]);
        } else {
            return response('Unauthorized.', 401);
        }
    }

    private function makeJWT()
    {
        $jwt = JWT::get(env('APP_PUBLIC_KEY'), ['nonce' => 'this is nonce']);
        return $jwt;
    }
}
