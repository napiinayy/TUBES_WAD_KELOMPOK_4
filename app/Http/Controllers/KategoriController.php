<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the kategoris.
     */
    public function index()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('admin.kategoris.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new kategori.
     */
    public function create()
    {
        return view('admin.kategoris.create');
    }

    /**
     * Store a newly created kategori in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori',
        ]);

        Kategori::create($validated);

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified kategori.
     */
    public function show(Kategori $kategori)
    {
        $kategori->load(['barangs', 'pengadaans']);
        return view('admin.kategoris.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified kategori.
     */
    public function edit(Kategori $kategori)
    {
        return view('admin.kategoris.edit', compact('kategori'));
    }

    /**
     * Update the specified kategori in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified kategori from storage.
     */
    public function destroy(Kategori $kategori)
    {
        // Check if kategori is being used
        if ($kategori->barangs()->count() > 0 || $kategori->pengadaans()->count() > 0) {
            return redirect()->route('admin.kategoris.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
