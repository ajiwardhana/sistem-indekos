<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use App\Models\User;

class KamarController extends Controller
{
    public function index()
    {

        $kamar = Kamar::where('status', 'tersedia')->get();
        return view('kamar.index', compact('kamars'));
    }
 

}