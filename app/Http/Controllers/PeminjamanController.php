<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Lab;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // Filter by current user if aslab
        if (auth()->user()->role === 'aslab') {
            $peminjamans = Peminjaman::with(['lab', 'user'])
                ->where('peminjam', auth()->id())
                ->latest()
                ->get();
        } else {
            $peminjamans = Peminjaman::with(['lab', 'user'])->latest()->get();
        }

        return view('aslab.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $labs = Lab::all();
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();
        return view('aslab.peminjaman.create', compact('labs', 'barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'id_lab' => 'required|exists:labs,id',
            'kelas' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan_peminjaman' => 'required|string',
        ]);

        $barang = Barang::findOrFail($validated['kategori_id']);
        // Optional availability check: block if item is currently borrowed
        $alreadyBorrowed = Peminjaman::where('kategori_id', $validated['kategori_id'])
            ->where('status', 'dipinjam')
            ->exists();
        if ($alreadyBorrowed) {
            return back()->withErrors(['kategori_id' => 'Item ini sedang dipinjam dan belum tersedia.'])->withInput();
        }
        $validated['nama_barang'] = $barang->nama_barang; // keep name for display/backward compatibility
        $validated['peminjam'] = auth()->user()->id ?? 1;
        $validated['status'] = 'dipinjam';

        Peminjaman::create($validated);

        return redirect()->route('aslab.peminjaman.index')
                         ->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function show($peminjaman)
    {
        $peminjaman = Peminjaman::with(['lab', 'user'])->findOrFail($peminjaman);
        return view('aslab.peminjaman.show', compact('peminjaman'));
    }

    public function edit($peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman);
        $labs = Lab::all();
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();
        return view('aslab.peminjaman.edit', compact('peminjaman', 'labs', 'barangs'));
    }

    public function update(Request $request, $peminjaman)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'id_lab' => 'required|exists:labs,id',
            'kelas' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan_peminjaman' => 'required|string',
        ]);

        $barang = Barang::findOrFail($validated['kategori_id']);
        $validated['nama_barang'] = $barang->nama_barang;

        $peminjaman = Peminjaman::findOrFail($peminjaman);
        $peminjaman->update($validated);

        return redirect()->route('aslab.peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil diupdate!');
    }

    public function destroy($peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman);
        $peminjaman->delete();

        return redirect()->route('aslab.peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil dihapus!');
    }
    
    /**
     * Update peminjaman status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:dipinjam,dikembalikan,terlambat',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => $request->status]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $peminjaman->status
            ]);
        }

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui');
    }
}
