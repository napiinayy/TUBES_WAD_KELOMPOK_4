<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KategoriController extends Controller
{
    /**
     * Display a listing of kategori.
     */
    public function index(): JsonResponse
    {
        $kategoris = Kategori::all();
        return response()->json($kategoris);
    }

    /**
     * Store a newly created kategori.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create($validated);
        return response()->json($kategori, 201);
    }

    /**
     * Display the specified kategori.
     */
    public function show($id): JsonResponse
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json($kategori);
    }

    /**
     * Update the specified kategori.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);
        return response()->json($kategori);
    }

    /**
     * Remove the specified kategori.
     */
    public function destroy($id): JsonResponse
    {
        $kategori = Kategori::findOrFail($id);
        
        // Check if kategori has related items
        if ($kategori->barangs()->count() > 0 || $kategori->pengadaans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete kategori with related items'
            ], 422);
        }
        
        $kategori->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Kategori deleted successfully'
        ]);
    }
}