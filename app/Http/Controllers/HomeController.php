<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengadaan;
use App\Models\Keluhan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'aslab') {
            // Get latest data for aslab dashboard
            $peminjaman = Peminjaman::with(['user', 'lab'])->latest()->take(5)->get();
            $pengadaan = Pengadaan::with(['lab'])->latest()->take(5)->get();
            $keluhan = Keluhan::latest()->take(5)->get();
            
            return view('aslab.dashboard', compact('peminjaman', 'pengadaan', 'keluhan'));
        }
        
        return redirect('/login');
    }
}