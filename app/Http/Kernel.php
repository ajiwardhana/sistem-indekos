<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\AdminMiddleware;

class Kernel extends HttpKernel
{
    
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \App\Http\Middleware\AuthenticateWithBasicAuth::class,
    'auth.session' => \App\Http\Middleware\ValidateSession::class,
    'cache.headers' => \App\Http\Middleware\SetCacheHeaders::class,
    'can' => \App\Http\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'password.confirm' => \App\Http\Middleware\RequirePassword::class,
    'signed' => \App\Http\Middleware\ValidateSignature::class,
    'throttle' => \App\Http\Middleware\ThrottleRequests::class,
    'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
    
    // PASTIKAN PERSIS SEPERTI INI:
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];
}

