<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization'); // Format: Bearer <token>
        $token = $token ? str_replace('Bearer ', '', $token) : null;

        if(!$token || $token != env('API_TOKEN')){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
