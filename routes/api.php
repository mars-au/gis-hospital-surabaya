<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ObjekPointController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua route di sini otomatis punya prefix /api
| Contoh: Route::get('/points') → /api/points
*/

// =========================
// OBJEK POINT (FASILITAS)
// =========================
Route::get('/points', [ObjekPointController::class, 'index']);
Route::get('/objek-point/{id}', [ObjekPointController::class, 'show']);
Route::post('/objek-point', [ObjekPointController::class, 'store']);
Route::put('/objek-point/{id}', [ObjekPointController::class, 'update']);
Route::delete('/objek-point/{id}', [ObjekPointController::class, 'destroy']);

// =========================
// SEARCH (PENCARIAN)
// =========================

// 🔍 Search non-spasial (nama, kategori, kecamatan)
Route::get('/search/attribute', [SearchController::class, 'searchByAttribute']);

// 📍 Search spasial (radius dari titik klik peta)
Route::get('/search/radius', [SearchController::class, 'searchByRadius']);

// 🏠 Search spasial dari ALAMAT (FITUR BARU KAMU)
Route::get('/search/address', [SearchController::class, 'searchByAddress']);
