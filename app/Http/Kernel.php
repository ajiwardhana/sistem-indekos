<?php

class Kernel
{
    protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,  # Pastikan ini ada
    // ...
    
];
}