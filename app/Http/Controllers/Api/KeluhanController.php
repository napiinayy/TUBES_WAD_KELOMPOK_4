<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\KeluhanController as WebKeluhanController;
use App\Models\Keluhan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KeluhanController extends WebKeluhanController
{
    public function index(): JsonResponse
    {
        $keluhans = Keluhan::latest()->get();
        return response()->json($keluhans);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis_keluhan' => 'required|string',
            'deskripsi_keluhan' => 'required|string',
        ]);

        $keluhan = Keluhan::create([
            'nama_item' => $request->nama_item,
            'jenis_keluhan' => $request->jenis_keluhan,
            'deskripsi_keluhan' => $request->deskripsi_keluhan,
            'status' => 'pending',
        ]);

        return response()->json($keluhan, 201);
    }

    public function show($id): JsonResponse
    {
        $keluhan = Keluhan::findOrFail($id);
        return response()->json($keluhan);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis_keluhan' => 'required|string',
            'deskripsi_keluhan' => 'required|string',
            'status' => 'required|in:pending,resolved',
        ]);

        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update($validated);
        return response()->json($keluhan);
    }

    public function destroy($id): JsonResponse
    {
        $keluhan = Keluhan::findOrFail($id);
        $keluhan->delete();
        return response()->json(['message' => 'Keluhan deleted successfully']);
    }
}