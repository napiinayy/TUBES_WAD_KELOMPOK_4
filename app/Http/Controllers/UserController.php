<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lab;
use App\Models\Pengadaan;
use App\Models\Peminjaman;
use App\Models\Keluhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('laboratorium')
            ->where('role', '!=', 'super_admin')
            ->latest()
            ->get()
            ->map(function ($user) {
                $user->lab_name = $user->laboratorium->nama_lab ?? '-';
                return $user;
            });

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $labs = Lab::all();
        return view('admin.users.create', compact('labs'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kode_aslab' => 'required|string|max:50|unique:users,kode_aslab',
            'email' => 'nullable|email|max:255|unique:users,email',
            'username' => 'required|string|max:100|unique:users,username',
            'id_lab' => 'nullable|exists:labs,id',
            'jurusan' => 'nullable|string|max:100',
            'role' => 'required|in:aslab,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // For admins, no labs required
        if ($validated['role'] === 'admin') {
            $validated['id_lab'] = null;
            $validated['jurusan'] = null;
        } elseif ($validated['role'] === 'aslab') {
            $request->validate([
                'id_lab' => 'required|exists:labs,id',
                'jurusan' => 'required|string|max:100',
            ]);
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Attach lab for aslab
        if ($validated['role'] === 'aslab' && $validated['id_lab']) {
            $user->labs()->attach($validated['id_lab']);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::with(['laboratorium', 'labs'])->findOrFail($id);

        // Add computed properties
        $user->lab_name = $user->laboratorium->nama_lab ?? '-';
        $user->total_pengadaan = \App\Models\Pengadaan::where('pengaju', $user->name)->count();
        $user->total_peminjaman = \App\Models\Peminjaman::where('peminjam', $user->name)->count();
        $user->total_keluhan = \App\Models\Keluhan::where('pelapor', $user->name)->count();

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $labs = Lab::all();
        
        return view('admin.users.edit', compact('user', 'labs'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kode_aslab' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'kode_aslab')->ignore($user->id)
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'username' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($user->id)
            ],
            'id_lab' => 'nullable|exists:labs,id', // Make nullable
            'jurusan' => 'nullable|string|max:100', // Make nullable
            'role' => 'required|in:aslab,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // For admins, set id_lab and jurusan to null
        if ($validated['role'] === 'admin') {
            $validated['id_lab'] = null;
            $validated['jurusan'] = null;
        } elseif ($validated['role'] === 'aslab') {
            // For aslabs, ensure id_lab and jurusan are provided
            $request->validate([
                'id_lab' => 'required|exists:labs,id',
                'jurusan' => 'required|string|max:100',
            ]);
        }

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting super admin or self
        if ($user->role === 'super_admin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus Super Admin');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus');
    }
}