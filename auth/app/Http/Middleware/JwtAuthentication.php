<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthentication
{
    /**
     * Handle an incoming request.
     * Middleware que verifica el token del request, y refresca el token si hay algun error, si por alguna manera el token es modificado el sistema arrojara error
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (\Throwable $th) {
            if ($th instanceof TokenExpiredException) {

                $token = JWTAuth::refresh();
                $request->headers->set('refresh', true);
                $request->headers->set('token', $token);
                $request->headers->set('Authorization', 'Bearer ' . $token);

                return $next($request);
            }
            if ($th instanceof TokenInvalidException) {
                return response()->json(["msg" => "Token invalid"], 401);
            }
            if ($th instanceof TokenBlacklistedException) {
                return response()->json(["msg" => "session close"], 500);
            }
            return response()->json(["msg" => "Token not found"], 400);
        }
    }
}
