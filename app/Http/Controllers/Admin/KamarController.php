<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;

class KamarController extends Controller
{
    public function index()
    {

        $kamar = Kamar::where('status', 'tersedia')->get();
        return view('kamar.index', compact('kamars'));
    }


}