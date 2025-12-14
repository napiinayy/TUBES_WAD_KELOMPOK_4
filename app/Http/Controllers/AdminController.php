<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function dashboard()
{
return view('admin.dashboard');
}
    // TAMPILKAN FORM PROFIL
    public function editProfil()
{
    $user = Auth::user();
return view('admin.profil', compact('user'));
}
  // UPDATE PROFIL
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:100',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update data dasar
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;

        // Update password (jika diisi)
        if ($request->filled('password')) {

            // Cek password lama
            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'Kata sandi saat ini tidak sesuai.',
                ]);
            }

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil admin berhasil diperbarui.');
    }
}
