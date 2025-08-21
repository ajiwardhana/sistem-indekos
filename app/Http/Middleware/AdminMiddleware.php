<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }   

    /**
     * Determine if the user is a regular user.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return Auth::check() && Auth::user()->role === 'user';
    }
}