<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GenerateUniqueSession
{
    public function handle(Request $request, Closure $next)
    {
        // Generate session ID unik jika belum ada
        if (!$request->hasSession() || !$request->session()->getId()) {
            $request->session()->setId(uniqid());
            $request->session()->start();
        }

        return $next($request);
    }
}