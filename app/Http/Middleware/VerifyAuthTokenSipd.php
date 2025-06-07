<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class VerifyAuthTokenSipd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthorized: No token provided'], 401);
        }
        $response = Http::withToken($token)->get(env('AUTH_SERVICE_URL') . '/api/verify-token');
        if ($response->status() !== 200) {
            return response()->json(['message' => 'Unauthorized: Invalid token'], 401);
        }
        $request->merge(['user' => $response->json()['user']]);

        return $next($request);
    }

}
