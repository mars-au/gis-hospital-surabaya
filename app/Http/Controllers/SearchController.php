<?php

namespace App\Http\Controllers;

use App\Models\ObjekPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Search non-spasial berdasarkan nama atau filter
     */
    public function searchByAttribute(Request $request)
    {
        $query = ObjekPoint::with(['kategori', 'kecamatan']);

        // Search by nama
        if ($request->has('nama') && $request->nama != '') {
            $query->where('nama_objek', 'LIKE', '%' . $request->nama . '%');
        }

        // Filter by kategori
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter by kecamatan
        if ($request->has('kecamatan_id') && $request->kecamatan_id != '') {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        $results = $query->get();

        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'data' => $results
        ]);
    }

    /**
     * Search spasial berdasarkan radius (Haversine formula)
     */
    public function searchByRadius(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|numeric|min:0.1|max:50' // radius dalam km
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;
        $radius = $request->radius;

        // Haversine formula untuk SQL Server
        // Menghitung jarak dalam kilometer
        // SQL Server menggunakan POWER dan SQRT, bukan acos
        $results = ObjekPoint::select('*')
            ->selectRaw("
                (6371 * 2 * ASIN(SQRT(
                    POWER(SIN((RADIANS(?) - RADIANS(latitude)) / 2), 2) +
                    COS(RADIANS(?)) * COS(RADIANS(latitude)) *
                    POWER(SIN((RADIANS(?) - RADIANS(longitude)) / 2), 2)
                ))) AS distance
            ", [$lat, $lat, $lng])
            ->with(['kategori', 'kecamatan'])
            ->get()
            ->filter(function($point) use ($radius) {
                return $point->distance <= $radius;
            })
            ->sortBy('distance')
            ->values();

        return response()->json([
            'success' => true,
            'center' => [
                'latitude' => $lat,
                'longitude' => $lng
            ],
            'radius_km' => $radius,
            'count' => $results->count(),
            'data' => $results
        ]);
    }

    /**
     * Get objek point terdekat dari lokasi tertentu
     */
    public function getNearestPoints(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'limit' => 'nullable|integer|min:1|max:50'
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;
        $limit = $request->limit ?? 10;

        $results = ObjekPoint::select('*')
            ->selectRaw("
                (6371 * 2 * ASIN(SQRT(
                    POWER(SIN((RADIANS(?) - RADIANS(latitude)) / 2), 2) +
                    COS(RADIANS(?)) * COS(RADIANS(latitude)) *
                    POWER(SIN((RADIANS(?) - RADIANS(longitude)) / 2), 2)
                ))) AS distance
            ", [$lat, $lat, $lng])
            ->with(['kategori', 'kecamatan'])
            ->get()
            ->sortBy('distance')
            ->take($limit)
            ->values();

        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'data' => $results
        ]);
    }
}
