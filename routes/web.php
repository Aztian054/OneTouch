<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// ─────────────────────────────────────────────
//  PUBLIC SITE
// ─────────────────────────────────────────────
Route::get('/', [\App\Http\Controllers\Public\BerandaController::class, 'index'])->name('beranda');
Route::get('/layanan', [\App\Http\Controllers\Public\LayananController::class, 'index'])->name('layanan');
Route::get('/skm', [\App\Http\Controllers\Public\SkmController::class, 'index'])->name('skm');
Route::get('/ekspor', [\App\Http\Controllers\Public\EksporController::class, 'index'])->name('ekspor');
Route::get('/media', [\App\Http\Controllers\Public\MediaController::class, 'index'])->name('media');
Route::get('/aplikasi', [\App\Http\Controllers\Public\AplikasiController::class, 'index'])->name('aplikasi');
Route::get('/regulasi', [\App\Http\Controllers\Public\RegulasiController::class, 'index'])->name('regulasi');
Route::get('/tentang-kami', [\App\Http\Controllers\Public\TentangKamiController::class, 'index'])->name('tentang-kami');

// ─────────────────────────────────────────────
//  AUTH
// ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─────────────────────────────────────────────
//  ADMIN
// ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Sertifikat
    Route::resource('sertifikat', \App\Http\Controllers\Admin\SertifikatController::class);

    // Inspeksi
    Route::resource('inspeksi', \App\Http\Controllers\Admin\InspeksiController::class);

    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{user}/assign-officer', [\App\Http\Controllers\Admin\UserController::class, 'assignOfficer'])->name('users.assign-officer');

    // Laporan
    Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/sertifikat/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'sertifikatPdf'])->name('laporan.sertifikat.pdf');
    Route::get('/laporan/sertifikat/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'sertifikatExcel'])->name('laporan.sertifikat.excel');
    Route::get('/laporan/inspeksi/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'inspeksiPdf'])->name('laporan.inspeksi.pdf');
    Route::get('/laporan/inspeksi/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'inspeksiExcel'])->name('laporan.inspeksi.excel');
});

// ─────────────────────────────────────────────
//  OFFICER
// ─────────────────────────────────────────────
Route::prefix('officer')->name('officer.')->middleware(['auth', 'role:officer'])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Officer\DashboardController::class, 'index'])->name('dashboard');

    // Sertifikat
    Route::resource('sertifikat', \App\Http\Controllers\Officer\SertifikatController::class);

    // Inspeksi
    Route::resource('inspeksi', \App\Http\Controllers\Officer\InspeksiController::class);

    // Laporan
    Route::get('/laporan', [\App\Http\Controllers\Officer\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/sertifikat/pdf', [\App\Http\Controllers\Officer\LaporanController::class, 'sertifikatPdf'])->name('laporan.sertifikat.pdf');
    Route::get('/laporan/sertifikat/excel', [\App\Http\Controllers\Officer\LaporanController::class, 'sertifikatExcel'])->name('laporan.sertifikat.excel');
    Route::get('/laporan/inspeksi/pdf', [\App\Http\Controllers\Officer\LaporanController::class, 'inspeksiPdf'])->name('laporan.inspeksi.pdf');
    Route::get('/laporan/inspeksi/excel', [\App\Http\Controllers\Officer\LaporanController::class, 'inspeksiExcel'])->name('laporan.inspeksi.excel');
});

// ─────────────────────────────────────────────
//  USER
// ─────────────────────────────────────────────
Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

    // Sertifikat (read-only + view own)
    Route::get('/sertifikat', [\App\Http\Controllers\User\SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/{sertifikat}', [\App\Http\Controllers\User\SertifikatController::class, 'show'])->name('sertifikat.show');

    // Inspeksi (read-only + view own)
    Route::get('/inspeksi', [\App\Http\Controllers\User\InspeksiController::class, 'index'])->name('inspeksi.index');
    Route::get('/inspeksi/{inspeksi}', [\App\Http\Controllers\User\InspeksiController::class, 'show'])->name('inspeksi.show');

    // Laporan
    Route::get('/laporan', [\App\Http\Controllers\User\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/sertifikat/pdf', [\App\Http\Controllers\User\LaporanController::class, 'sertifikatPdf'])->name('laporan.sertifikat.pdf');
    Route::get('/laporan/sertifikat/excel', [\App\Http\Controllers\User\LaporanController::class, 'sertifikatExcel'])->name('laporan.sertifikat.excel');
});
