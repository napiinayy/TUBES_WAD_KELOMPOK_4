<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    public function index()
    {
        $keluhans = Keluhan::latest()->get();
        return view('admin.keluhan.index', compact('keluhans'));
    }

    public function create()
    {
        return view('admin.keluhan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis_keluhan' => 'required|string',
            'deskripsi_keluhan' => 'required|string',
        ]);

        Keluhan::create([
            'nama_item' => $request->nama_item,
            'jenis_keluhan' => $request->jenis_keluhan,
            'deskripsi_keluhan' => $request->deskripsi_keluhan,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.keluhan.index')
            ->with('success', 'Keluhan berhasil dikirim');
    }

    public function show($id)
    {
        $keluhan = Keluhan::findOrFail($id);
        return view('admin.keluhan.show', compact('keluhan'));
    }

    public function edit($id)
    {
        $keluhan = Keluhan::findOrFail($id);
        return view('admin.keluhan.edit', compact('keluhan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis_keluhan' => 'required|string',
            'deskripsi_keluhan' => 'required|string',
        ]);

        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update([
            'nama_item' => $request->nama_item,
            'jenis_keluhan' => $request->jenis_keluhan,
            'deskripsi_keluhan' => $request->deskripsi_keluhan,
        ]);

        return redirect()->route('admin.keluhan.index')
            ->with('success', 'Keluhan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $keluhan = Keluhan::findOrFail($id);
        $keluhan->delete();
        return redirect()->route('admin.keluhan.index')
            ->with('success', 'Keluhan berhasil dihapus');
    }
}
