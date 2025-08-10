<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }
    return redirect('/dashboard')->with('error', 'Akses hanya untuk admin!');
}

    public function terminate($request, $response)
    {
        // Optional: Log the request or perform any cleanup
    }
}