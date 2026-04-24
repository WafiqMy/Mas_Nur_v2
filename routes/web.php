<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PersewaanController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\ProfilMasjidController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;

// ===================== HALAMAN PUBLIK =====================

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/acara', [EventController::class, 'index'])->name('event.index');
Route::get('/acara/{id}', [EventController::class, 'show'])->name('event.show');

Route::get('/profil-masjid', [ProfilMasjidController::class, 'show'])->name('profil-masjid.show');
Route::get('/profil-masjid/struktur', [ProfilMasjidController::class, 'struktur'])->name('profil-masjid.struktur');

Route::get('/reservasi', [PersewaanController::class, 'index'])->name('reservasi.index');
Route::get('/reservasi/barang/{id}', [PersewaanController::class, 'show'])->name('reservasi.barang.show');

// ===================== AUTH =====================

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/verifikasi', [OtpController::class, 'showVerifikasiForm'])->name('verifikasi.form');
Route::post('/verifikasi', [OtpController::class, 'verifikasi'])->name('verifikasi.post');

Route::get('/lupa-password', [OtpController::class, 'showLupaPasswordForm'])->name('lupa-password');
Route::post('/lupa-password/request-otp', [OtpController::class, 'requestOtp'])->name('lupa-password.request-otp');
Route::post('/lupa-password/verify-otp', [OtpController::class, 'verifyOtp'])->name('lupa-password.verify-otp');
Route::post('/lupa-password/reset', [OtpController::class, 'resetPassword'])->name('lupa-password.reset');

// ===================== USER (LOGIN REQUIRED) =====================

Route::middleware('auth.user')->group(function () {
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/status', [ReservasiController::class, 'statusPemesanan'])->name('reservasi.status');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/count', [NotifikasiController::class, 'count'])->name('notifikasi.count');

    Route::get('/profil', [ProfileUserController::class, 'show'])->name('profil-user.show');
    Route::post('/profil/update', [ProfileUserController::class, 'update'])->name('profil-user.update');
    Route::post('/profil/request-otp', [ProfileUserController::class, 'requestOtp'])->name('profil-user.request-otp');
    Route::post('/profil/update-password', [ProfileUserController::class, 'updatePassword'])->name('profil-user.update-password');
});

// ===================== ADMIN ONLY =====================

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    // Berita
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/tambah', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    // Acara
    Route::get('/acara', [EventController::class, 'index'])->name('acara.index');
    Route::get('/acara/tambah', [EventController::class, 'create'])->name('acara.create');
    Route::post('/acara', [EventController::class, 'store'])->name('acara.store');
    Route::get('/acara/{id}/edit', [EventController::class, 'edit'])->name('acara.edit');
    Route::put('/acara/{id}', [EventController::class, 'update'])->name('acara.update');
    Route::delete('/acara/{id}', [EventController::class, 'destroy'])->name('acara.destroy');

    // Kelola Barang
    Route::get('/reservasi', [PersewaanController::class, 'adminIndex'])->name('reservasi.index');
    Route::get('/reservasi/tambah-barang', [PersewaanController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi/barang', [PersewaanController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/barang/{id}/edit', [PersewaanController::class, 'edit'])->name('reservasi.edit');
    Route::put('/reservasi/barang/{id}', [PersewaanController::class, 'update'])->name('reservasi.update');
    Route::delete('/reservasi/barang/{id}', [PersewaanController::class, 'destroy'])->name('reservasi.destroy');

    // Permintaan Reservasi
    Route::get('/reservasi/permintaan', [ReservasiController::class, 'permintaan'])->name('reservasi.permintaan');
    Route::get('/reservasi/permintaan/{id}', [ReservasiController::class, 'detailPermintaan'])->name('reservasi.detail-permintaan');
    Route::post('/reservasi/permintaan/{id}/status', [ReservasiController::class, 'updateStatus'])->name('reservasi.update-status');

    // Profil Masjid
    Route::get('/profil-masjid', [ProfilMasjidController::class, 'edit'])->name('profil-masjid.edit');
    Route::put('/profil-masjid', [ProfilMasjidController::class, 'update'])->name('profil-masjid.update');
    Route::get('/profil-masjid/struktur', [ProfilMasjidController::class, 'editStruktur'])->name('profil-masjid.edit-struktur');
    Route::put('/profil-masjid/struktur', [ProfilMasjidController::class, 'updateStruktur'])->name('profil-masjid.update-struktur');
});

// ===================== API (JSON) =====================

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/kalender-reservasi/{id}', [ReservasiController::class, 'kalender'])->name('kalender-reservasi');
});
