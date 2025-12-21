<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KeluhanController extends Controller
{
    /**
     * Get the prefix based on the route
     */
    private function getPrefix()
    {
        $route = request()->route();
        $name = $route ? $route->getName() : '';
        return Str::startsWith($name, 'aslab.') ? 'aslab' : 'admin';
    }

    public function index()
    {
        $prefix = $this->getPrefix();
        
        // Filter by current user if aslab
        if (auth()->user()->role === 'aslab') {
            $keluhans = Keluhan::where('created_by', auth()->id())->latest()->get();
        } else {
            $keluhans = Keluhan::latest()->get();
        }
        
        return view("{$prefix}.keluhan.index", compact('keluhans'));
    }

    public function create()
    {
        $prefix = $this->getPrefix();
        return view("{$prefix}.keluhan.create");
    }

    public function store(Request $request)
    {
        $prefix = $this->getPrefix();
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
            'created_by' => auth()->id(),
        ]);

        return redirect()->route("{$prefix}.keluhan.index")
            ->with('success', 'Keluhan berhasil dikirim');
    }

    public function show($id)
    {
        $prefix = $this->getPrefix();
        $keluhan = Keluhan::findOrFail($id);
        return view("{$prefix}.keluhan.show", compact('keluhan'));
    }

    public function edit($id)
    {
        $prefix = $this->getPrefix();
        
        // Only admin can edit keluhan
        if ($prefix === 'aslab') {
            return redirect()->route("{$prefix}.keluhan.index")
                ->with('error', 'Hanya admin yang dapat mengedit keluhan');
        }
        
        $keluhan = Keluhan::findOrFail($id);
        return view("{$prefix}.keluhan.edit", compact('keluhan'));
    }

    public function update(Request $request, $id)
    {
        $prefix = $this->getPrefix();
        
        // Only admin can update keluhan
        if ($prefix === 'aslab') {
            return redirect()->route("{$prefix}.keluhan.index")
                ->with('error', 'Hanya admin yang dapat mengedit keluhan');
        }
        
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis_keluhan' => 'required|string',
            'deskripsi_keluhan' => 'required|string',
            'status' => 'required|string|in:pending,resolved,rejected',
        ]);

        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update($request->only(['nama_item', 'jenis_keluhan', 'deskripsi_keluhan', 'status']));

        return redirect()->route("{$prefix}.keluhan.index")
            ->with('success', 'Keluhan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $prefix = $this->getPrefix();
        $keluhan = Keluhan::findOrFail($id);
        $keluhan->delete();
        return redirect()->route("{$prefix}.keluhan.index")
            ->with('success', 'Keluhan berhasil dihapus');
    }

    /**
     * Update status only (pending/resolved/rejected)
     */
    public function updateStatus(Request $request, $id)
    {
        $prefix = $this->getPrefix();
        
        // Only admin can update status
        if ($prefix === 'aslab') {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Hanya admin yang dapat mengubah status'], 403);
            }
            return redirect()->route("{$prefix}.keluhan.index")
                ->with('error', 'Hanya admin yang dapat mengubah status');
        }
        
        $request->validate([
            'status' => 'required|string|in:pending,resolved,rejected',
        ]);

        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update(['status' => $request->status]);

        // Support AJAX and normal form submission
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $keluhan->status]);
        }

        return redirect()->route("{$prefix}.keluhan.index")
            ->with('success', 'Status keluhan berhasil diperbarui');
    }
}
