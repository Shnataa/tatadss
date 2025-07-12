<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HasilAkhirController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('login', [AuthController::class, 'loginPage'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('dashboard/periode', PeriodeController::class);
    Route::resource('dashboard/kriteria', KriteriaController::class);
    Route::resource('dashboard/parameter', ParameterController::class);
    Route::resource('dashboard/alternatif', AlternatifController::class);
    Route::resource('dashboard/penilaian', PenilaianController::class);
    Route::get('dashboard/registrasi', [AuthController::class, 'index'])->name('registrasi.index');
    Route::get('dashboard/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
    Route::get('dashboard/perhitungan/hitung', [PerhitunganController::class, 'hitungSmart'])->name('perhitungan.hitung');
    Route::get('dashboard/hasil-akhir', [HasilAkhirController::class, 'index'])->name('hasilAkhir.index');
    Route::get('/periode/{id}/activate', [PeriodeController::class, 'activate'])->name('periode.activate');
    Route::get('/periode/{id}/deactivate', [PeriodeController::class, 'deactivate'])->name('periode.deactivate');
    Route::get('dashboard/hasil-akhir/export-pdf/{periodeId}', [HasilAkhirController::class, 'exportPdf'])->name('hasilAkhir.exportPdf');
    Route::get('dashboard/hasil-akhir/export-excel/{periodeId}', [HasilAkhirController::class, 'exportExcel'])->name('hasilAkhir.exportExcel');
    // Route::post('dashboard/perhitungan/hitung', [PerhitunganController::class, 'hitungTopsis'])->name('perhitungan.hitungTopsis');
    
});

Route::get('register', [AuthController::class, 'registerPage'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::get('/user/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
    Route::post('/user/change-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
});

Route::get('/chart-data', [ChartController::class, 'getChartData']);
Route::get('/chart', function () {
    return view('chart');
});
Route::get('/chart-data-penilaian', [ChartController::class, 'getPenilaianData']);