<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }
    return redirect('/')->with('error', 'Akses hanya untuk Admin!');
}

    public function terminate($request, $response)
    {
        // Optional: Log the request or perform any cleanup
    }
}