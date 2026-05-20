<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================
// 🏠 Halaman Utama
// ====================
Route::get('/', function () {
    return view('index');
})->middleware('admin')->name('index');

// ====================
// 👨‍🎓 CRUD Siswa
// ====================
Route::resource('siswa', SiswaController::class)->middleware('admin');

// ====================
// 🕒 Fitur Absensi
// ====================

// Halaman scan QR
Route::get('/absensi/scan', [AbsensiController::class, 'scan'])
    ->name('absensi.scan');

// Generate QR Code
Route::get('/absensi/qrcode', [AbsensiController::class, 'qrcode'])
    ->middleware('admin')
    ->name('absensi.qrcode');

// Simpan hasil scan
Route::post('/absensi/storeScan', [AbsensiController::class, 'storeScan'])
    ->name('absensi.storeScan');


// ===================================================
// 📁 ARSIP ABSENSI (DITAMBAHKAN DI SINI)
// ===================================================

// halaman arsip
Route::get('/absensi/arsip', [AbsensiController::class, 'arsip'])
    ->middleware('admin')
    ->name('absensi.arsip');

// restore data
Route::post('/absensi/restore/{id}', [AbsensiController::class, 'restore'])
    ->middleware('admin')
    ->name('absensi.restore');
// ===================================================


// CRUD Absensi Manual (resource)
Route::resource('absensi', AbsensiController::class)
    ->middleware('admin');

// ====================
// 📊 Rekap Absensi
// ====================

Route::get('/absensi/rekap/{id}', [AbsensiController::class, 'rekap'])
    ->middleware('admin')
    ->name('absensi.rekap');

Route::get('/absensi/rekap/{id}/pdf', [AbsensiController::class, 'rekapPdf'])
    ->middleware('admin')
    ->name('absensi.rekap.pdf');

Route::get('/rekap', [RekapController::class, 'index'])
    ->middleware('admin')
    ->name('rekap.index');

// ====================
// 🚨 Fallback
// ====================
Route::fallback(function () {
    return redirect()->route('index');
});

// ====================
// 🔐 LOGIN ADMIN
// ====================

// form login
Route::get('/admin/login', [AuthController::class, 'showLogin'])
    ->name('admin.login');

// proses login
Route::post('/admin/login', [AuthController::class, 'login'])
    ->name('login.process');

// logout
Route::post('/admin/logout', [AuthController::class, 'logout'])
    ->name('admin.logout');

// register admin
Route::get('/admin/register', [AuthController::class, 'showRegister'])
    ->name('admin.register');

Route::post('/admin/register', [AuthController::class, 'register'])
    ->name('register.process');


// ====================
// 🔐 AREA ADMIN
// ====================
Route::middleware('admin')->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('index');
    })->name('admin.dashboard');

});
