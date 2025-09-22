<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::user()->role;

                if ($role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($role === 'pemilik') {
                    return redirect()->route('pemilik.dashboard');
                } elseif ($role === 'penyewa') {
                    return redirect()->route('penyewa.dashboard');
                }

                // default redirect kalau role tidak dikenal
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
