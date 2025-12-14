<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    public function index()
    {
        $keluhans = Keluhan::latest()->get();
        return view('aslab.keluhan.index', compact('keluhans'));
    }

    public function create()
    {
        return view('aslab.keluhan.create');
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

        return redirect('/test-keluhan')
            ->with('success', 'Keluhan berhasil dikirim');
    }

    public function show($id)
    {
        $keluhan = Keluhan::findOrFail($id);
        return view('aslab.keluhan.show', compact('keluhan'));
    }

    public function destroy($id)
    {
    $keluhan = Keluhan::findOrFail($id);
    $keluhan->delete();
    return redirect('/test-keluhan')
        ->with('success', 'Keluhan berhasil dihapus');
    }
}
