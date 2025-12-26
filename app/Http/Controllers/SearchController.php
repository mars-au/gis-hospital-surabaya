<?php

namespace App\Http\Controllers;

use App\Models\ObjekPoint;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * 1. SEARCH NON-SPASIAL
     * (Nama fasilitas, kategori, kecamatan)
     */
    public function searchByAttribute(Request $request)
    {
        $query = ObjekPoint::with(['kategori', 'kecamatan']);

        // Filter nama fasilitas
        if ($request->filled('nama')) {
            $query->where('nama_objek', 'LIKE', '%' . $request->nama . '%');
        }

        // Filter kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter kecamatan
        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        $results = $query->get();

        return response()->json([
            'success' => true,
            'count'   => $results->count(),
            'data'    => $results
        ]);
    }

    /**
     * 2. SEARCH SPASIAL BERDASARKAN RADIUS (KLIK PETA)
     */
    public function searchByRadius(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius'    => 'required|numeric|min:0.1|max:50'
        ]);

        $lat    = $request->latitude;
        $lng    = $request->longitude;
        $radius = $request->radius; // km

        // Haversine Formula (km)
        $results = ObjekPoint::select('*')
            ->selectRaw("
                (6371 * 2 * ASIN(SQRT(
                    POWER(SIN((RADIANS(?) - RADIANS(latitude)) / 2), 2) +
                    COS(RADIANS(?)) * COS(RADIANS(latitude)) *
                    POWER(SIN((RADIANS(?) - RADIANS(longitude)) / 2), 2)
                ))) AS distance
            ", [$lat, $lat, $lng])
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->with(['kategori', 'kecamatan'])
            ->get();

        return response()->json([
            'success' => true,
            'center'  => [
                'latitude'  => $lat,
                'longitude' => $lng
            ],
            'radius_km' => $radius,
            'count'     => $results->count(),
            'data'      => $results
        ]);
    }
}
