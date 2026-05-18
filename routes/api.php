<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BeritaApiController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\PersewaanApiController;
use App\Http\Controllers\Api\ReservasiApiController;
use App\Http\Controllers\Api\FoodCourtApiController;
use App\Http\Controllers\Api\InfaqApiController;
use App\Http\Controllers\Api\InfaqRekeningApiController;
use App\Http\Controllers\Api\ProfilMasjidApiController;
use App\Http\Controllers\Api\PublikasiApiController;

/*
|--------------------------------------------------------------------------
| API Routes - Masjid Nurul Huda
| Base URL: /api/v1/...
|--------------------------------------------------------------------------
|
| Semua response format:
| { "status": "success"|"error", "message": "...", "data": {...} }
|
*/

Route::prefix('v1')->group(function () {

    // ===================== AUTH =====================
    Route::post('/login',                   [AuthApiController::class, 'login']);
    Route::post('/verifikasi-otp',          [AuthApiController::class, 'verifikasiOtp']);
    Route::post('/lupa-password/request',   [AuthApiController::class, 'lupaPasswordRequest']);
    Route::post('/lupa-password/reset',     [AuthApiController::class, 'lupaPasswordReset']);
    Route::get('/profil/{username}',        [AuthApiController::class, 'profil']);

    // Route yang butuh token (admin mobile)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthApiController::class, 'logout']);
        Route::get('/me',      [AuthApiController::class, 'me']);

        // ===================== ADMIN — ACARA =====================
        Route::prefix('admin')->group(function () {
            Route::post('/event',        [EventApiController::class, 'store']);
            Route::post('/event/{id}',   [EventApiController::class, 'update']);
            Route::delete('/event/{id}', [EventApiController::class, 'destroy']);

            // ===================== ADMIN — BERITA =====================
            Route::post('/berita',        [BeritaApiController::class, 'store']);
            Route::post('/berita/{id}',   [BeritaApiController::class, 'update']);
            Route::delete('/berita/{id}', [BeritaApiController::class, 'destroy']);

            // ===================== ADMIN — KELOLA BARANG SEWA =====================
            Route::post('/persewaan',        [PersewaanApiController::class, 'adminStore']);
            Route::post('/persewaan/{id}',   [PersewaanApiController::class, 'adminUpdate']);
            Route::delete('/persewaan/{id}', [PersewaanApiController::class, 'adminDestroy']);

            // ===================== ADMIN — KELOLA PERMINTAAN RESERVASI =====================
            Route::get('/reservasi',               [PersewaanApiController::class, 'semuaReservasi']);
            Route::patch('/reservasi/{id}/status', [PersewaanApiController::class, 'updateStatusReservasi']);

            // ===================== ADMIN — FOOD COURT =====================
            Route::post('/food-court',        [FoodCourtApiController::class, 'store']);
            Route::post('/food-court/{id}',   [FoodCourtApiController::class, 'update']);
            Route::delete('/food-court/{id}', [FoodCourtApiController::class, 'destroy']);

            // ===================== ADMIN — INFAQ DANA MASUK =====================
            Route::get('/infaq/ringkasan',           [InfaqApiController::class, 'adminRingkasan']);
            Route::get('/infaq/dana',                [InfaqApiController::class, 'adminDana']);
            Route::get('/infaq/pengeluaran',         [InfaqApiController::class, 'adminPengeluaran']);
            Route::post('/infaq/dana',               [InfaqApiController::class, 'storeDana']);
            Route::post('/infaq/dana/{id}',          [InfaqApiController::class, 'updateDana']);
            Route::delete('/infaq/dana/{id}',        [InfaqApiController::class, 'destroyDana']);

            // ===================== ADMIN — INFAQ DANA KELUAR =====================
            Route::post('/infaq/pengeluaran',        [InfaqApiController::class, 'storePengeluaran']);
            Route::post('/infaq/pengeluaran/{id}',   [InfaqApiController::class, 'updatePengeluaran']);
            Route::delete('/infaq/pengeluaran/{id}', [InfaqApiController::class, 'destroyPengeluaran']);

            // ===================== ADMIN — INFAQ REKENING =====================
            Route::get('/infaq/rekening',                    [InfaqRekeningApiController::class, 'index']);
            Route::post('/infaq/rekening',                   [InfaqRekeningApiController::class, 'store']);
            Route::post('/infaq/rekening/{id}',              [InfaqRekeningApiController::class, 'update']);
            Route::delete('/infaq/rekening/{id}',            [InfaqRekeningApiController::class, 'destroy']);
            Route::patch('/infaq/rekening/{id}/toggle',      [InfaqRekeningApiController::class, 'toggleActive']);

            // ===================== ADMIN — PUBLIKASI =====================
            Route::get('/publikasi',                    [PublikasiApiController::class, 'adminIndex']);
            Route::post('/publikasi',                   [PublikasiApiController::class, 'store']);
            Route::post('/publikasi/{id}',              [PublikasiApiController::class, 'update']);
            Route::delete('/publikasi/{id}',            [PublikasiApiController::class, 'destroy']);
            Route::patch('/publikasi/{id}/toggle',      [PublikasiApiController::class, 'toggleActive']);
        });
    });

    // ===================== BERITA (publik) =====================
    Route::get('/berita',       [BeritaApiController::class, 'index']);
    Route::get('/berita/{id}',  [BeritaApiController::class, 'show']);

    // ===================== EVENT (publik) =====================
    Route::get('/event',        [EventApiController::class, 'index']);
    Route::get('/event/{id}',   [EventApiController::class, 'show']);

    // ===================== PERSEWAAN (publik) =====================
    Route::get('/persewaan',                    [PersewaanApiController::class, 'index']);
    Route::get('/persewaan/{id}',               [PersewaanApiController::class, 'show']);
    Route::get('/persewaan/{id}/kalender',      [PersewaanApiController::class, 'kalender']);

    // ===================== FOOD COURT (publik) =====================
    Route::get('/food-court',       [FoodCourtApiController::class, 'index']);
    Route::get('/food-court/{id}',  [FoodCourtApiController::class, 'show']);

    // ===================== INFAQ (publik) =====================
    Route::get('/infaq',            [InfaqApiController::class, 'index']);
    Route::get('/infaq/rekening',   [InfaqApiController::class, 'rekening']);
    Route::get('/infaq/laporan',    [InfaqApiController::class, 'laporan']);

    // ===================== PROFIL MASJID (publik) =====================
    Route::get('/profil-masjid',          [ProfilMasjidApiController::class, 'index']);
    Route::get('/profil-masjid/struktur', [ProfilMasjidApiController::class, 'struktur']);

    // ===================== PUBLIKASI (publik) =====================
    Route::get('/publikasi', [PublikasiApiController::class, 'index']);

    // ===================== RESERVASI (butuh login) =====================
    Route::post('/reservasi',                       [ReservasiApiController::class, 'store']);
    Route::get('/reservasi/riwayat/{username}',     [ReservasiApiController::class, 'riwayat']);
    Route::get('/reservasi/{id}',                   [ReservasiApiController::class, 'show']);

});
