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
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get latest 3 users
        $latestUsers = User::with('laboratorium')
            ->where('role', '!=', 'super_admin')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($user) {
                $user->lab_name = $user->laboratorium->nama_lab ?? '-';
                return $user;
            });

        // Get latest 3 barang items
        $latestBarangs = \App\Models\Barang::with('kategori')->latest()->take(3)->get();

        // Get latest 3 complaints
        $latestKeluhans = Keluhan::latest()->take(3)->get();

        // Get counts for infographics
        $totalUsers = User::where('role', '!=', 'super_admin')->count();
        $totalBarangs = \App\Models\Barang::count();
        $totalKeluhans = Keluhan::where('status', 'pending')->count();

        // Get latest pengadaan and peminjaman for existing tables
        $pengadaan = Pengadaan::with('lab')->latest()->take(5)->get();
        $peminjaman = Peminjaman::with(['user', 'lab'])->latest()->take(5)->get();
        // Filter to ensure we only pass valid model instances to the view table
        // Load all keluhan for the admin table so the list stays in sync
        $keluhan = Keluhan::latest()->get();

        return view('admin.dashboard', compact(
            'latestUsers',
            'latestBarangs', 
            'latestKeluhans',
            'totalUsers',
            'totalBarangs',
            'totalKeluhans',
            'pengadaan',
            'peminjaman',
            'keluhan'
        ));
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
            'id_lab' => 'nullable|array',
            'id_lab.*' => 'exists:labs,id',
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
                'id_lab' => 'required|array|min:1',
                'id_lab.*' => 'exists:labs,id',
                'jurusan' => 'required|string|max:100',
            ]);
        }

        $validated['password'] = Hash::make($validated['password']);
        
        // Set name field from nama_lengkap for database compatibility
        $validated['name'] = $validated['nama_lengkap'];
        
        // Store first lab in id_lab for backward compatibility
        $labIds = $validated['id_lab'] ?? [];
        $validated['id_lab'] = !empty($labIds) ? $labIds[0] : null;

        $user = User::create($validated);

        // Attach all labs for aslab
        if ($validated['role'] === 'aslab' && !empty($labIds)) {
            $user->labs()->attach($labIds);
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
        $user = User::with('labs')->findOrFail($id);
        $labs = Lab::all();
        
        return view('admin.users.edit', compact('user', 'labs'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Check if aslab is editing their own profile
        $isAslabEditingSelf = auth()->user()->role === 'aslab' && auth()->id() == $id;

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
            'id_lab' => $isAslabEditingSelf ? 'nullable|array' : 'nullable|array',
            'id_lab.*' => 'exists:labs,id',
            'jurusan' => $isAslabEditingSelf ? 'nullable|string|max:100' : 'nullable|string|max:100',
            'role' => $isAslabEditingSelf ? 'nullable|in:aslab,admin' : 'required|in:aslab,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        // If aslab is editing their own profile, preserve academic information
        if ($isAslabEditingSelf) {
            // Keep existing role, lab, and jurusan
            $validated['role'] = $user->role;
            $validated['jurusan'] = $user->jurusan;
            // Don't update labs
            unset($validated['id_lab']);
        } else {
            // Admin updating user - process normally
            // For admins, set id_lab and jurusan to null
            if ($validated['role'] === 'admin') {
                $validated['id_lab'] = null;
                $validated['jurusan'] = null;
                $user->labs()->detach();
            } elseif ($validated['role'] === 'aslab') {
                // For aslabs, ensure id_lab and jurusan are provided
                $request->validate([
                    'id_lab' => 'required|array|min:1',
                    'id_lab.*' => 'exists:labs,id',
                    'jurusan' => 'required|string|max:100',
                ]);
                
                // Sync labs for aslab
                $labIds = $validated['id_lab'];
                $user->labs()->sync($labIds);
                
                // Store first lab in id_lab for backward compatibility
                $validated['id_lab'] = $labIds[0];
            }
        }

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Set name field from nama_lengkap for database compatibility
        $validated['name'] = $validated['nama_lengkap'];

        $user->update($validated);

        // Redirect based on who is updating
        if (auth()->id() == $id && auth()->user()->role === 'aslab') {
            return redirect()
                ->route('admin.users.edit', $id)
                ->with('success', 'Profil berhasil diperbarui');
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui');
    }

    /**
     * Store a new lab via AJAX.
     */
    public function storeLab(Request $request)
    {
        $validated = $request->validate([
            'nama_lab' => 'required|string|max:255|unique:labs,nama_lab',
        ]);

        try {
            // Auto-generate kode_lab from nama_lab (first 3 letters + random number)
            $validated['kode_lab'] = strtoupper(substr($validated['nama_lab'], 0, 3)) . '-' . random_int(1000, 9999);
            
            $lab = Lab::create($validated);

            return response()->json([
                'success' => true,
                'lab' => $lab,
                'message' => 'Lab berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
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