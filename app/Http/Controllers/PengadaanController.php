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
        // Filter by current user if aslab
        if (auth()->user()->role === 'aslab') {
            $pengadaans = Pengadaan::with(['lab', 'kategori'])
                ->where('pengaju', auth()->user()->name)
                ->latest()
                ->get();
        } else {
            $pengadaans = Pengadaan::with(['lab', 'kategori'])
                ->latest()
                ->get();
        }
        
        return view('aslab.pengadaan.index', compact('pengadaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get unique kategoris by nama_kategori
        $kategoris = Kategori::select('nama_kategori')
            ->distinct()
            ->whereNotNull('nama_kategori')
            ->orderBy('nama_kategori')
            ->get();
        $labs = Lab::all();
        
        return view('aslab.pengadaan.create', compact('kategoris', 'labs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string',
            'id_lab' => 'required|exists:labs,id',
            'jumlah' => 'required|integer|min:1',
            'alasan_pengadaan' => 'required|string',
        ]);

        // Find the kategori by nama_kategori to get the id
        $kategori = Kategori::where('nama_kategori', $validated['kategori_barang'])->first();
        
        if (!$kategori) {
            return back()->withErrors(['kategori_barang' => 'Kategori tidak ditemukan.'])->withInput();
        }

        // Tambahkan field tambahan
        $validated['id_kategori'] = $kategori->id;
        $validated['pengaju'] = auth()->user()->name ?? 'Admin';
        $validated['status'] = 'pending'; // Default status

        Pengadaan::create($validated);

        return redirect()->route('aslab.pengadaan.index')
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

        return redirect()->route('aslab.pengadaan.index')
            ->with('success', 'Data pengadaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengadaan $pengadaan)
    {
        $pengadaan->delete();

        return redirect()->route('aslab.pengadaan.index')
            ->with('success', 'Data pengadaan berhasil dihapus.');
    }

    /**
     * Update pengadaan status and auto-create kategori when approved
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,completed',
        ]);

        $pengadaan = Pengadaan::with('kategori')->findOrFail($id);
        $oldStatus = $pengadaan->status;
        $newStatus = $request->status;

        $pengadaan->update(['status' => $newStatus]);

        // Auto-create barang when status changes to approved
        if ($newStatus === 'approved' && $oldStatus !== 'approved') {
            // Check if barang with this name already exists
            $existingBarang = \App\Models\Barang::where('nama_barang', $pengadaan->nama_barang)->first();
            
            if (!$existingBarang) {
                \App\Models\Barang::create([
                    'nama_barang' => $pengadaan->nama_barang,
                    'deskripsi' => $pengadaan->spesifikasi ?? 'Barang dari pengadaan yang disetujui',
                    'category_id' => $pengadaan->id_kategori,
                ]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $pengadaan->status
            ]);
        }

        return redirect()->back()->with('success', 'Status pengadaan berhasil diperbarui');
    }
}