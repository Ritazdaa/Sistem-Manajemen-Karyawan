<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\RiwayatAbsenController;
use App\Http\Controllers\GajiController;


// Rute halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk mahasiswa
Route::get('/mahasiswa', [MahasiswaController::class, 'index']);

// Rute untuk registrasi
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Rute untuk login
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');

// Rute yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Rute untuk data pengguna
    Route::get('/data-pengguna', [DashboardController::class, 'showDataPengguna'])->name('dashboard.showDataPengguna')->middleware('admin');

    // Rute untuk absen karyawan
    Route::get('/absen', [AbsenController::class, 'showForm'])->name('dashboard.absenKaryawan');
    Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');
    
    // Rute untuk profil
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil.show');

    // Rute untuk pengumuman
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    // Rute untuk informasi gaji
    Route::get('/informasi/gaji', [GajiController::class, 'index'])->name('informasi.gaji');
    Route::post('/informasi/gaji/store', [GajiController::class, 'store'])->name('informasi.gaji.store');
    Route::get('/edit/{id}', [GajiController::class, 'edit'])->name('informasi.gaji.edit');
    Route::post('/update/{id}', [GajiController::class, 'update'])->name('informasi.gaji.update');
    Route::delete('/delete/{id}', [GajiController::class, 'destroy'])->name('informasi.gaji.delete');

    // Rute untuk riwayat absen
    Route::get('/riwayat_absen', [AbsenController::class, 'riwayat'])->name('riwayat_absen.index');
});

// Rute untuk riayat absen
Route::get('/riwayat-absen', [RiwayatAbsenController::class, 'index'])->name('riwayat_absen.index');
Route::post('/riwayat-absen/terima/{id}', [RiwayatAbsenController::class, 'terima'])->name('riwayat_absen.terima');
Route::post('/riwayat-absen/tolak/{id}', [RiwayatAbsenController::class, 'tolak'])->name('riwayat_absen.tolak');
Route::get('/riwayat_absen', [AbsenController::class, 'riwayat'])->name('riwayat_absen.index');

// Rute untuk menampilkan daftar gaji
Route::get('/informasi', [GajiController::class, 'index'])->name('informasi.gaji');

// Rute untuk menampilkan detail gaji
Route::get('/gaji/{id}', [GajiController::class, 'showDetail'])->name('gaji.detail');

// Rute untuk menampilkan form edit gaji
Route::get('/gaji/{id}/edit', [GajiController::class, 'edit'])->name('gaji.edit');

// Rute untuk mengupdate gaji
Route::put('/gaji/{id}', [GajiController::class, 'update'])->name('gaji.update');

// Rute untuk menghapus gaji
Route::delete('/gaji/{id}', [GajiController::class, 'destroy'])->name('gaji.destroy');

// Rute untuk menyimpan gaji baru
Route::post('/gaji', [GajiController::class, 'store'])->name('gaji.store');