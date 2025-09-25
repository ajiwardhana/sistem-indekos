<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
{
    $users = User::query();

    // Filter berdasarkan role (jika ada)
    if ($role = $request->get('role')) {
        $users->where('role', $role);
    }

    // Ambil semua atau paginate
    $users = $users->paginate(10);

    return view('admin.users.index', compact('users'));
}

}
