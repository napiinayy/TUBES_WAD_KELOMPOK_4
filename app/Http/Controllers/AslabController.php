<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AslabController extends Controller
{
    public function dashboard()
{
    return view('aslab.dashboard');
}
// TAMPILKAN FORM PROFIL
    public function editProfil()
    {
        $user = Auth::user();
        return view('aslab.profil', compact('user'));
    }

    // PROSES UPDATE PROFIL
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // VALIDASI
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kode_aslab' => 'required|string|max:50',
            'kata_sandi' => 'nullable|min:8|confirmed',
        ]);

 // UPDATE DATA
        $user->nama_lengkap = $request->nama_lengkap;
        $user->kode_aslab = $request->kode_aslab;

        // JIKA PASSWORD DIISI
        if ($request->filled('kata_sandi')) {
            $user->password = Hash::make($request->kata_sandi);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
