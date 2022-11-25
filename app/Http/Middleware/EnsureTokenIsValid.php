<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use STS\JWT\JWTFacade as JWT;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $jwt = $request->header('Authorization');
        $isValid = JWT::parse($jwt)->isValid(env('APP_PUBLIC_KEY'));
        if ($isValid) {
            return $next($request);
        } else {
            return response('Unauthorized.', 401);
        }
    }
    
    
}
