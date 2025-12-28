<?php

namespace App\Http\Controllers;

use App\Models\ObjekPoint;
use App\Models\Jalan;
use App\Models\Area;
use App\Models\Kategori;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        $kecamatans = Kecamatan::all();
        
        return view('map.index', compact('kategoris', 'kecamatans'));
    }

    public function getPoints()
    {
        $points = ObjekPoint::with(['kategori', 'kecamatan'])->get();
        
        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $points->map(function ($point) {
                return [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [(float)$point->longitude, (float)$point->latitude]
                    ],
                    'properties' => [
                        'id' => $point->id,
                        'nama_objek' => $point->nama_objek,
                        'kategori' => $point->kategori->nama_kategori ?? '',
                        'kecamatan' => $point->kecamatan->nama_kecamatan ?? '',
                        'deskripsi' => $point->deskripsi,
                        'alamat' => $point->alamat,
                        'telepon' => $point->telepon,
                        'icon' => $point->kategori->icon ?? 'marker'
                    ]
                ];
            })
        ]);
    }

    public function getLines()
    {
        $lines = Jalan::all();
        
        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $lines->map(function ($line) {
                return [
                    'type' => 'Feature',
                    'geometry' => json_decode($line->koordinat_json),
                    'properties' => [
                        'id' => $line->id,
                        'nama_jalan' => $line->nama_jalan,
                        'tipe_jalan' => $line->tipe_jalan,
                        'deskripsi' => $line->deskripsi
                    ]
                ];
            })
        ]);
    }

    public function getPolygons()
    {
        $areas = Area::all();
        
        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $areas->map(function ($area) {
                return [
                    'type' => 'Feature',
                    'geometry' => json_decode($area->polygon_json),
                    'properties' => [
                        'id' => $area->id,
                        'nama_area' => $area->nama_area,
                        'tipe_area' => $area->tipe_area,
                        'deskripsi' => $area->deskripsi
                    ]
                ];
            })
        ]);
    }

    public function getPolygonByKecamatan(Request $request)
    {
        $kecamatanId = $request->get('kecamatan_id');
        
        if (!$kecamatanId) {
            return response()->json([
                'type' => 'FeatureCollection',
                'features' => []
            ]);
        }

        $kecamatan = Kecamatan::find($kecamatanId);
        
        if (!$kecamatan) {
            return response()->json([
                'type' => 'FeatureCollection',
                'features' => []
            ]);
        }

        $area = Area::where('nama_area', $kecamatan->nama_kecamatan)->first();
        
        if (!$area) {
            return response()->json([
                'type' => 'FeatureCollection',
                'features' => []
            ]);
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => [[
                'type' => 'Feature',
                'geometry' => json_decode($area->polygon_json),
                'properties' => [
                    'id' => $area->id,
                    'nama_area' => $area->nama_area,
                    'tipe_area' => $area->tipe_area,
                    'deskripsi' => $area->deskripsi,
                    'kecamatan_id' => $kecamatanId,
                    'nama_kecamatan' => $kecamatan->nama_kecamatan
                ]
            ]]
        ]);
    }
}
