<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    // app/Http/Middleware/AdminMiddleware.php
public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->isAdmin()) {
        return $next($request);
    }
    
    abort(403, 'Akses hanya untuk administrator.');
}
}