<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

// ─────────────────────────────────────────────
//  PUBLIC SITE
// ─────────────────────────────────────────────
Route::get('/', [\App\Http\Controllers\Public\BerandaController::class, 'index'])->name('beranda');
Route::get('/home', function() {
    if (Auth::check()) {
        return match(Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'officer' => redirect()->route('officer.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => redirect('/'),
        };
    }
    return redirect()->route('login');
})->name('home');
Route::get('/layanan', [\App\Http\Controllers\Public\LayananController::class, 'index'])->name('layanan');
Route::get('/skm', [\App\Http\Controllers\Public\SkmController::class, 'index'])->name('skm');
Route::post('/skm/submit', [\App\Http\Controllers\Public\SkmController::class, 'submit'])->name('skm.submit');
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
    Route::get('/users/export/pdf', [\App\Http\Controllers\Admin\UserController::class, 'exportPdf'])->name('users.export.pdf');
    Route::get('/users/export/excel', [\App\Http\Controllers\Admin\UserController::class, 'exportExcel'])->name('users.export.excel');

    // News & Activities Management
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);

    // Data Ekspor Management
    Route::get('/data-ekspor', [\App\Http\Controllers\Admin\DataEksporController::class, 'index'])->name('data-ekspor.index');
    Route::get('/data-ekspor/create', [\App\Http\Controllers\Admin\DataEksporController::class, 'create'])->name('data-ekspor.create');
    Route::post('/data-ekspor', [\App\Http\Controllers\Admin\DataEksporController::class, 'store'])->name('data-ekspor.store');
    Route::get('/data-ekspor/{dataEkspor}/edit', [\App\Http\Controllers\Admin\DataEksporController::class, 'edit'])->name('data-ekspor.edit');
    Route::put('/data-ekspor/{dataEkspor}', [\App\Http\Controllers\Admin\DataEksporController::class, 'update'])->name('data-ekspor.update');
    Route::delete('/data-ekspor/all', [\App\Http\Controllers\Admin\DataEksporController::class, 'destroyAll'])->name('data-ekspor.destroy-all');
    Route::delete('/data-ekspor/{dataEkspor}', [\App\Http\Controllers\Admin\DataEksporController::class, 'destroy'])->name('data-ekspor.destroy');

    // SKM Surveys
    Route::get('/skm', [\App\Http\Controllers\Admin\SkmSurveyController::class, 'index'])->name('skm.index');
    Route::get('/skm/{skmSurvey}', [\App\Http\Controllers\Admin\SkmSurveyController::class, 'show'])->name('skm.show');
    Route::get('/skm/{skmSurvey}/edit', [\App\Http\Controllers\Admin\SkmSurveyController::class, 'edit'])->name('skm.edit');
    Route::put('/skm/{skmSurvey}', [\App\Http\Controllers\Admin\SkmSurveyController::class, 'update'])->name('skm.update');
    Route::delete('/skm/{skmSurvey}', [\App\Http\Controllers\Admin\SkmSurveyController::class, 'destroy'])->name('skm.destroy');
    Route::get('/skm/export/excel', [\App\Http\Controllers\Admin\SkmSurveyController::class, 'exportExcel'])->name('skm.export.excel');
    Route::get('/skm/export/pdf', [\App\Http\Controllers\Admin\SkmSurveyController::class, 'exportPdf'])->name('skm.export.pdf');

    // Data SKM (Target & Realisasi)
    Route::resource('data-skm', \App\Http\Controllers\Admin\DataSkmController::class);

    // Laporan
    Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/sertifikat/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'sertifikatPdf'])->name('laporan.sertifikat.pdf');
    Route::get('/laporan/sertifikat/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'sertifikatExcel'])->name('laporan.sertifikat.excel');
    Route::get('/laporan/inspeksi/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'inspeksiPdf'])->name('laporan.inspeksi.pdf');
    Route::get('/laporan/inspeksi/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'inspeksiExcel'])->name('laporan.inspeksi.excel');
    Route::get('/laporan/users', [\App\Http\Controllers\Admin\LaporanController::class, 'usersPdf'])->name('laporan.users');
    Route::get('/laporan/users/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'usersPdf'])->name('laporan.users.pdf');
    Route::get('/laporan/users/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'usersExcel'])->name('laporan.users.excel');
    Route::get('/laporan/skm-surveys', [\App\Http\Controllers\Admin\LaporanController::class, 'skmSurveysPdf'])->name('laporan.skm-surveys');
    Route::get('/laporan/skm-surveys/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'skmSurveysPdf'])->name('laporan.skm-surveys.pdf');
    Route::get('/laporan/skm-surveys/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'skmSurveysExcel'])->name('laporan.skm-surveys.excel');
    Route::get('/laporan/data-ekspor', [\App\Http\Controllers\Admin\LaporanController::class, 'dataEksporPdf'])->name('laporan.data-ekspor');
    Route::get('/laporan/data-ekspor/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'dataEksporPdf'])->name('laporan.data-ekspor.pdf');
    Route::get('/laporan/data-ekspor/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'dataEksporExcel'])->name('laporan.data-ekspor.excel');
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
    Route::get('/laporan/inspeksi/pdf', [\App\Http\Controllers\User\LaporanController::class, 'inspeksiPdf'])->name('laporan.inspeksi.pdf');
    Route::get('/laporan/inspeksi/excel', [\App\Http\Controllers\User\LaporanController::class, 'inspeksiExcel'])->name('laporan.inspeksi.excel');
});
