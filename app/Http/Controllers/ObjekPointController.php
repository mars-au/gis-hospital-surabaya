<?php

namespace App\Http\Controllers;

use App\Models\ObjekPoint;
use App\Models\Kategori;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class ObjekPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $points = ObjekPoint::with(['kategori', 'kecamatan'])->get();
        return response()->json($points);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $kecamatans = Kecamatan::all();
        return view('objek_point.create', compact('kategoris', 'kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_objek' => 'required|string|max:200',
            'kategori_id' => 'required|exists:kategori,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'deskripsi' => 'nullable|string',
            'kecamatan_id' => 'nullable|exists:kecamatan,id',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20'
        ]);

        $point = ObjekPoint::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Objek point berhasil ditambahkan',
            'data' => $point->load(['kategori', 'kecamatan'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $point = ObjekPoint::with(['kategori', 'kecamatan'])->findOrFail($id);
        return response()->json($point);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $point = ObjekPoint::findOrFail($id);
        $kategoris = Kategori::all();
        $kecamatans = Kecamatan::all();
        return view('objek_point.edit', compact('point', 'kategoris', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $point = ObjekPoint::findOrFail($id);
        
        $validated = $request->validate([
            'nama_objek' => 'required|string|max:200',
            'kategori_id' => 'required|exists:kategori,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'deskripsi' => 'nullable|string',
            'kecamatan_id' => 'nullable|exists:kecamatan,id',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20'
        ]);

        $point->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Objek point berhasil diupdate',
            'data' => $point->load(['kategori', 'kecamatan'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $point = ObjekPoint::findOrFail($id);
        $point->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Objek point berhasil dihapus'
        ]);
    }
}
