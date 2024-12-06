<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$role)
    {
        // Pastikan pengguna sudah login dan memiliki role yang sesuai
        if (!Auth::check() && !Auth::user()->role === $role) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Periksa apakah role pengguna termasuk dalam daftar role yang diizinkan
        if (!in_array($user->role, $role)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
