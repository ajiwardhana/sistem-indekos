<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;

class KamarController extends Controller
{
    public function index()
    {

        $kamar = Kamar::where('status', 'tersedia')->get();
        return view('kamar.index', compact('kamars'));
    }
}