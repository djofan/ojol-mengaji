<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\Auth\PortalLoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [PortalLoginController::class, 'show'])->name('login');
Route::post('/login', [PortalLoginController::class, 'login']);
Route::post('/logout-portal', [PortalLoginController::class, 'logout'])->name('portal.logout');

Route::view('/tentang-kami', 'pages.tentang-kami');
Route::view('/faq', 'pages.faq');
Route::view('/cara-bergabung', 'pages.cara-bergabung');
Route::view('/kontak', 'pages.kontak');

Route::prefix('api/wilayah')->group(function () {
    Route::get('/provinsi', [WilayahController::class, 'provinsi']);
    Route::get('/kota/{provinsiId}', [WilayahController::class, 'kota']);
    Route::get('/kecamatan/{kotaId}', [WilayahController::class, 'kecamatan']);
    Route::get('/kelurahan/{kecamatanId}', [WilayahController::class, 'kelurahan']);
    Route::get('/geocode-kelurahan', [WilayahController::class, 'geocodeKelurahan']);
});
