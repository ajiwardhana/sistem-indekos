<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect based on user role
     */
    public function redirectTo()
    {
        if (auth()->user()->isAdmin()) {
            return '/dashboard'; // Tetap ke dashboard biasa, tapi kontennya beda
            // atau jika ingin URL berbeda:
            // return '/admin/dashboard';
        }
        
        return '/dashboard';
    }
}