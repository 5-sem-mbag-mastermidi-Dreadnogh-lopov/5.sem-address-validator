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
            $jwt = JWT::get('penisBoy', ['anything' => 'here']);
            return response()->json(['success' => true, 'jwt' => $jwt]);
        } else {
            return response()->json(['success' => false], 401,);
        }
    }

    public function test(Request $request)
    {
        $jwt = $request->jwt;
        $isValid = JWT::parse($jwt)->isValid('penisBoy');
        return response()->json(['isValid' => $isValid]);
    }
}
