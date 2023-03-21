<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtRefresh
{
    /**
     * Handle an incoming request.
     *  Middleware que asigna un nuevo token al usuario
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('refresh')) {
            try {
                JWTAuth::parseToken()->authenticate();

                $token = $request->header('token');

                $ttl = JWTAuth::factory()->getTTL() * 60;

                $response = $next($request);
                $response->headers->set('TOKEN', $token);
                $response->headers->set('TTL', $ttl);

                return $response;
            } catch (\Throwable $th) {
                if ($th instanceof TokenExpiredException) {
                    return response()->json(["msg" => "Token expired"], 401);
                }
                if ($th instanceof TokenInvalidException) {
                    return response()->json(["msg" => "Token invalid"], 401);
                }
                if ($th instanceof TokenBlacklistedException) {
                    return response()->json(["msg" => "session close"], 500);
                }

                return response()->json(["msg" => "Token not found"], 400);
            }
        } else {
            return $next($request);
        }
    }
}
