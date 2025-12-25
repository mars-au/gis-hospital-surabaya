<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ObjekPointController;
use App\Http\Controllers\SearchController;

// Halaman utama peta
Route::get('/', [MapController::class, 'index'])->name('map.index');

// API endpoints untuk mendapatkan data GeoJSON
Route::prefix('api')->group(function () {
    // Get all layers
    Route::get('/points', [MapController::class, 'getPoints'])->name('api.points');
    Route::get('/lines', [MapController::class, 'getLines'])->name('api.lines');
    Route::get('/polygons', [MapController::class, 'getPolygons'])->name('api.polygons');
    
    // CRUD Objek Point
    Route::apiResource('objek-point', ObjekPointController::class);
    
    // Search endpoints
    Route::get('/search/attribute', [SearchController::class, 'searchByAttribute'])->name('api.search.attribute');
    Route::get('/search/radius', [SearchController::class, 'searchByRadius'])->name('api.search.radius');
    Route::get('/search/nearest', [SearchController::class, 'getNearestPoints'])->name('api.search.nearest');
});
