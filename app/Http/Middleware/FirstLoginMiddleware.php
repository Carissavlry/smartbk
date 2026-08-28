<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirstLoginMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Kalau belum login, skip
        if (!$user) {
            return $next($request);
        }

        // Kalau is_first_login = true DAN bukan sedang di halaman ganti password
        if ($user->is_first_login &&
            !$request->routeIs('first-login.form') &&
            !$request->routeIs('first-login.update') &&
            !$request->routeIs('logout')) {
            return redirect()->route('first-login.form');
        }

        return $next($request);
    }
}