<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;

/*
|--------------------------------------------------------------------------
| API Routes — Mobile Flutter
| Prefix  : /api/v1
| File ini didaftarkan di bootstrap/app.php
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // ── AUTH ──────────────────────────────────────────────────────────────
    Route::post('login',    [AuthApiController::class, 'login']);
    Route::post('logout',   [AuthApiController::class, 'logout']);
    Route::get('me',        [AuthApiController::class, 'me']);
    Route::patch('me',      [AuthApiController::class, 'updateProfil']);

    // ── LUPA PASSWORD / OTP ───────────────────────────────────────────────
    Route::post('lupa-password/request', [AuthApiController::class, 'sendOtp']);
    Route::post('verifikasi-otp',        [AuthApiController::class, 'verifyOtp']);
    Route::post('lupa-password/reset',   [AuthApiController::class, 'resetPassword']);

});
