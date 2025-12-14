<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        return view('admin.profil', compact('user'));
    }

    // UPDATE PROFIL
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'username'         => 'required|string|max:100|unique:users,username,' . $user->id,
            'current_password' => 'nullable|required_with:password',
            'password'         => 'nullable|min:8|confirmed',
        ]);

        // Update data
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username     = $request->username;

        // Update password
        if ($request->filled('password')) {

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

    //ADMIN EDIT USER LAIN (ASLAB)
    public function editAslab($id)
    {
        $user = User::where('role', 'aslab')->findOrFail($id);

        return view('admin.aslab.edit', compact('user'));
    }
    public function updateAslab(Request $request, $id)
    {
        $user = User::where('role', 'aslab')->findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:100|unique:users,username,' . $user->id,
            'kode_aslab'   => 'required|string|max:50',
            'password'     => 'nullable|min:8|confirmed',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->username     = $request->username;
        $user->kode_aslab   = $request->kode_aslab;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/admin/aslab')->with('success', 'Data aslab berhasil diperbarui');
    }
}
