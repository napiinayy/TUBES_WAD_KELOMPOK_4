<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /*Daftar kategori
     */
    public function index()
    {
        $items = Kategori::all()->map(function ($kategori) {
 
            $kategori->nama_barang  = $kategori->nama_kategori;
            $kategori->jenis_barang = $kategori->deskripsi;
            return $kategori;
        });
    
        $categories = Kategori::pluck('deskripsi')->unique();
    
        return view('admin.kategori.index', compact('items', 'categories'));
    }

    /*Form tambah kategori
     */
    public function create()
    {
        $categories = Kategori::pluck('deskripsi')->unique();

        return view('admin.kategori.create', compact('categories'));
    }

    /*nyimpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'jenis_barang' => 'required|string|max:255',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_barang,
            'deskripsi'     => $request->jenis_barang,
        ]);

        return redirect('/test-admin/kategori')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /*Detail kategori
     */
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->nama_barang  = $kategori->nama_kategori;
        $kategori->jenis_barang = $kategori->deskripsi;

        $item = $kategori;

        return view('admin.kategori.show', compact('item'));
    }

    /*Form edit kategori
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->nama_barang  = $kategori->nama_kategori;
        $kategori->jenis_barang = $kategori->deskripsi;

        $item = $kategori;
        $categories = Kategori::pluck('deskripsi')->unique();

        return view('admin.kategori.edit', compact('item', 'categories'));
    }

    /*Mengupdate kategori
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'jenis_barang' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_barang,
            'deskripsi'     => $request->jenis_barang,
        ]);

        return redirect('/test-admin/kategori')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /*Menghapus kategori
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect('/test-admin/kategori')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
