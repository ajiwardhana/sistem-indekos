<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
{
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
}

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}
