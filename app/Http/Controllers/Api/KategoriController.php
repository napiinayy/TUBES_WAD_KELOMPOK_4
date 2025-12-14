<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\KategoriController as WebKategoriController;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KategoriController extends WebKategoriController
{
    public function index(): JsonResponse
    {
        $kategoris = Kategori::all();
        return response()->json($kategoris);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create($validated);
        return response()->json($kategori, 201);
    }

    public function show($id): JsonResponse
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json($kategori);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);
        return response()->json($kategori);
    }

    public function destroy($id): JsonResponse
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return response()->json(['message' => 'Kategori deleted successfully']);
    }
}