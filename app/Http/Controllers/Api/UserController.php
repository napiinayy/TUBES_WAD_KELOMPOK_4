<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\UserController as WebUserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends WebUserController
{
    public function index(): JsonResponse
    {
        $users = User::with('laboratorium')
            ->where('role', '!=', 'super_admin')
            ->latest()
            ->get()
            ->map(function ($user) {
                $user->lab_name = $user->laboratorium->nama_lab ?? '-';
                return $user;
            });

        return response()->json($users);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kode_aslab' => 'required|string|max:50|unique:users,kode_aslab',
            'email' => 'nullable|email|max:255|unique:users,email',
            'username' => 'required|string|max:100|unique:users,username',
            'id_lab' => 'required|exists:labs,id',
            'jurusan' => 'required|string|max:100',
            'role' => 'required|in:aslab,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['name'] = $validated['nama_lengkap']; // Set name to nama_lengkap

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function show($id): JsonResponse
    {
        $user = User::with('laboratorium')->findOrFail($id);
        $user->lab_name = $user->laboratorium->nama_lab ?? '-';
        $user->total_pengadaan = \App\Models\Pengadaan::where('pengaju', $user->name)->count();
        $user->total_peminjaman = \App\Models\Peminjaman::where('peminjam', $user->name)->count();
        $user->total_keluhan = \App\Models\Keluhan::where('pelapor', $user->name)->count();

        return response()->json($user);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kode_aslab' => [
                'required',
                'string',
                'max:50',
                \Illuminate\Validation\Rule::unique('users', 'kode_aslab')->ignore($user->id)
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users', 'email')->ignore($user->id)
            ],
            'username' => [
                'nullable',
                'string',
                'max:100',
                \Illuminate\Validation\Rule::unique('users', 'username')->ignore($user->id)
            ],
            'id_lab' => 'required|exists:labs,id',
            'jurusan' => 'required|string|max:100',
            'role' => 'required|in:aslab,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['name'] = $validated['nama_lengkap']; // Set name to nama_lengkap
        $user->update($validated);

        return response()->json($user);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->role === 'super_admin') {
            return response()->json(['error' => 'Cannot delete super admin'], 403);
        }

        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'Cannot delete yourself'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}