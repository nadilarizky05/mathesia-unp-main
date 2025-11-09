<?php

namespace App\Http\Controllers;

use App\Models\MaterialSections;
use App\Http\Requests\StoreMaterialSectionsRequest;
use App\Http\Requests\UpdateMaterialSectionsRequest;
use App\Models\MaterialSection;
use Illuminate\Http\Request;

class MaterialSectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index($materialId)
    {
        $sections = MaterialSection::where('material_id', $materialId)
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sections,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request, $materialId)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'order' => 'integer|min:1',
            'wacana' => 'nullable|string',
            'masalah' => 'nullable|string',
            'berpikir_soal_1' => 'nullable|string',
            'berpikir_soal_2' => 'nullable|string',
            'rencanakan' => 'nullable|string',
            'selesaikan' => 'nullable|string',
            'periksa' => 'nullable|string',
            'kerjakan_1' => 'nullable|string',
            'kerjakan_2' => 'nullable|string',
        ]);

        $validated['material_id'] = $materialId;

        $section = MaterialSection::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Section berhasil dibuat',
            'data' => $section,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $section = MaterialSection::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $section,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialSection $materialSections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $section = MaterialSection::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'order' => 'integer|min:1',
            'wacana' => 'nullable|string',
            'masalah' => 'nullable|string',
            'berpikir_soal_1' => 'nullable|string',
            'berpikir_soal_2' => 'nullable|string',
            'rencanakan' => 'nullable|string',
            'selesaikan' => 'nullable|string',
            'periksa' => 'nullable|string',
            'kerjakan_1' => 'nullable|string',
            'kerjakan_2' => 'nullable|string',
        ]);

        $section->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Section berhasil diperbarui',
            'data' => $section,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $section = MaterialSection::findOrFail($id);
        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Section berhasil dihapus',
        ]);
    }
}