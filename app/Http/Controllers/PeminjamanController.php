<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Lab;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('lab')->latest()->get();
        return view('aslab.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $labs = Lab::all();
        return view('aslab.peminjaman.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_lab' => 'required|exists:labs,id',
            'kelas' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan_peminjaman' => 'required|string',
        ]);

        $validated['peminjam'] = auth()->user()->name ?? 'User';
        $validated['status'] = 'dipinjam';

        Peminjaman::create($validated);

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with('lab')->findOrFail($id);
        return view('aslab.peminjaman.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $labs = Lab::all();
        return view('aslab.peminjaman.edit', compact('peminjaman', 'labs'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_lab' => 'required|exists:labs,id',
            'kelas' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan_peminjaman' => 'required|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($validated);

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil diupdate!');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil dihapus!');
    }
}