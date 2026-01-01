<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KeluhanController extends Controller
{
    /**
     * Display a listing of keluhan.
     */
    public function index(): JsonResponse
    {
        $keluhans = Keluhan::latest()->get();
        return response()->json($keluhans);
    }

    /**
     * Store a newly created keluhan.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis_keluhan' => 'required|string',
            'deskripsi_keluhan' => 'required|string',
            'pelapor' => 'nullable|string|max:255',
            'created_by' => 'nullable|integer|exists:users,id',
        ]);

        $validated['status'] = 'pending';

        $keluhan = Keluhan::create($validated);

        return response()->json($keluhan, 201);
    }

    /**
     * Display the specified keluhan.
     */
    public function show($id): JsonResponse
    {
        $keluhan = Keluhan::findOrFail($id);
        return response()->json($keluhan);
    }

    /**
     * Update the specified keluhan.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis_keluhan' => 'required|string',
            'deskripsi_keluhan' => 'required|string',
            'pelapor' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,in_progress,completed,rejected',
        ]);

        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update($validated);
        
        return response()->json($keluhan);
    }

    /**
     * Remove the specified keluhan.
     */
    public function destroy($id): JsonResponse
    {
        $keluhan = Keluhan::findOrFail($id);
        $keluhan->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Keluhan deleted successfully'
        ]);
    }

    /**
     * Update keluhan status.
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:pending,in_progress,completed,rejected',
        ]);

        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'status' => $keluhan->status
        ]);
    }
}