<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\Kategori;
use App\Models\Lab;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengadaans = Pengadaan::with(['lab', 'kategori'])
            ->latest()
            ->get();
        
        return view('aslab.pengadaan.index', compact('pengadaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $labs = Lab::all();
        
        return view('aslab.pengadaan.create', compact('kategoris', 'labs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategoris,id',
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string',
            'id_lab' => 'required|exists:labs,id',
            'jumlah' => 'required|integer|min:1',
            'alasan_pengadaan' => 'required|string',
        ]);

        // Tambahkan field tambahan jika ada user yang login
        $validated['pengaju'] = auth()->user()->name ?? 'Admin';
        $validated['status'] = 'pending'; // Default status

        Pengadaan::create($validated);

        return redirect()->route('pengadaan.index')
            ->with('success', 'Pengajuan pengadaan barang berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengadaan $pengadaan)
    {
        $pengadaan->load(['lab', 'kategori']);
        
        return view('aslab.pengadaan.show', compact('pengadaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengadaan $pengadaan)
    {
        $kategoris = Kategori::all();
        $labs = Lab::all();
        
        return view('aslab.pengadaan.edit', compact('pengadaan', 'kategoris', 'labs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengadaan $pengadaan)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategoris,id',
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string',
            'id_lab' => 'required|exists:labs,id',
            'jumlah' => 'required|integer|min:1',
            'alasan_pengadaan' => 'required|string',
        ]);

        $pengadaan->update($validated);

        return redirect()->route('pengadaan.index')
            ->with('success', 'Data pengadaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengadaan $pengadaan)
    {
        $pengadaan->delete();

        return redirect()->route('pengadaan.index')
            ->with('success', 'Data pengadaan berhasil dihapus.');
    }
}