<?php

use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf; // untuk pdf rekam medis

// ==========================================
// IMPORT CONTROLLERS (SUDAH DIPERBAIKI)
// ==========================================

// Home
use App\Http\Controllers\HomeController;

// Admin Routes Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPasienController;
use App\Http\Controllers\Admin\AdminDokterController;
use App\Http\Controllers\Admin\AdminJadwalController;
use App\Http\Controllers\Admin\AdminRekamMedisController;
use App\Http\Controllers\Admin\AdminPembayaranController;
use App\Http\Controllers\Admin\AdminJadwalSistemController;
use App\Http\Controllers\Admin\AdminJadwalDokterController;
// Dokter Routes Controllers (Dialias agar tidak bentrok dengan milik Pasien)
use App\Http\Controllers\Dokter\PasienController as DokterPasienController;
use App\Http\Controllers\Dokter\RekamMedisController as DokterRekamMedisController;

// Pasien Routes Controller
use App\Http\Controllers\Pasien\PasienController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// RUTE PUBLIK (Tanpa perlu login)
// ==========================================
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// ==========================================
// RUTE GUEST (Hanya untuk yang BELUM login)
// ==========================================
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'submit'])->name('login.submit');
Route::view('/register', 'register')->name('register');
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'submit'])->name('register.submit');

// ==========================================
// RUTE AUTH (WAJIB LOGIN)
// ==========================================
Route::middleware('auth')->group(function () {

    // --------------------------------------
    // 1. ADMIN ROUTES
    // --------------------------------------
    Route::prefix('admin')->name('admin.')->middleware('role:A')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('pasien', AdminPasienController::class);

    Route::resource('dokter', AdminDokterController::class);
    Route::get('/dokter/jadwal/{jadwalDokter}/edit', [AdminJadwalDokterController::class, 'edit'])->name('dokter.jadwal.edit');
    Route::put('/dokter/jadwal/{jadwalDokter}', [AdminJadwalDokterController::class, 'update'])->name('dokter.jadwal.update');

    Route::resource('jadwal', AdminJadwalController::class);

    Route::resource('rekam-medis', AdminRekamMedisController::class);

    Route::resource('pembayaran', AdminPembayaranController::class);

    Route::get('/jadwal-sistem', [AdminJadwalSistemController::class, 'index'])->name('jadwal-sistem');

    // Edit jam harian (Senin–Minggu)
    Route::get('/jadwal-sistem/harian/{jadwalSistem}/edit', [AdminJadwalSistemController::class, 'editHarian'])->name('jadwal-sistem.harian.edit');
    Route::put('/jadwal-sistem/harian/{jadwalSistem}',      [AdminJadwalSistemController::class, 'updateHarian'])->name('jadwal-sistem.harian.update');

    // CRUD tanggal khusus (libur / jam berbeda)
    Route::get('/jadwal-sistem/create',              [AdminJadwalSistemController::class, 'create'])->name('jadwal-sistem.create');
    Route::post('/jadwal-sistem',                    [AdminJadwalSistemController::class, 'store'])->name('jadwal-sistem.store');
    Route::get('/jadwal-sistem/{jadwalSistem}/edit', [AdminJadwalSistemController::class, 'edit'])->name('jadwal-sistem.edit');
    Route::put('/jadwal-sistem/{jadwalSistem}',      [AdminJadwalSistemController::class, 'update'])->name('jadwal-sistem.update');
    Route::delete('/jadwal-sistem/{jadwalSistem}',   [AdminJadwalSistemController::class, 'destroy'])->name('jadwal-sistem.destroy');
    });

    // --------------------------------------
    // 2. DOKTER ROUTES (PORSI TUGAS KAMU - CLEAN & SAFE)
    // --------------------------------------
    Route::prefix('dokter')->middleware('role:D')->group(function () {
        // Halaman Tampilan Umum / View
        Route::get('/dashboard', function () { return view('dokter.dashboard-dokter'); })->name('dokter.dashboard');
        Route::get('/pengaturan-jadwal', function () { return view('dokter.pengaturan-jadwal'); })->name('dokter.pengaturan');
        Route::get('/profil', function () { return view('dokter.profil-dokter'); })->name('dokter.profil');
        Route::get('/pasien', function () { return view('dokter.pasien-dokter'); })->name('dokter.pasien');
        
        // Alur Jadwal & Aksi Pembuatan Rekam Medis (Memakai DokterPasienController)
        Route::get('/jadwal', [DokterPasienController::class, 'index'])->name('dokter.jadwal');
        Route::get('/jadwal/{id}/buat-rekam', [App\Http\Controllers\Dokter\PasienController::class, 'buatRekam'])->name('dokter.jadwal.buat-rekam');
        // Route untuk memproses form (POST)
        Route::post('/dokter/jadwal/{id}/simpan-rekam', [App\Http\Controllers\Dokter\PasienController::class, 'storeRekamMedis'])->name('dokter.rekam-medis');

        // Alur Riwayat Rekam Medis (Memakai DokterRekamMedisController)
        Route::get('/dokter/rekam-medis', [DokterRekamMedisController::class, 'index'])->name('dokter.rekam-medis');
    });
    
    // --------------------------------------
    // 3. PASIEN ROUTES
    // --------------------------------------
    // --------------------------------------
    // 3. PASIEN ROUTES
    // --------------------------------------
    Route::prefix('pasien')->name('pasien.')->middleware('role:P')->group(function () {
        
        // Dashboard & Profil
        Route::get('/dashboard', [PasienController::class, 'index'])->name('dashboard');
        Route::get('/profil', [PasienController::class, 'showProfil'])->name('profil');
        Route::get('/profil/edit', [PasienController::class, 'editProfil'])->name('profil.edit');
        Route::post('/profil/update', [PasienController::class, 'updateProfil'])->name('profil.update');
        
        // Jadwal & Janji
        Route::get('/buat-janji', [PasienController::class, 'buatJanji'])->name('buat-janji');
        Route::post('/buat-janji', [PasienController::class, 'storeJadwal'])->name('store_jadwal');
        Route::get('/riwayat-jadwal', [PasienController::class, 'riwayatJadwal'])->name('riwayat');
        Route::delete('/jadwal/{id}/batal', [PasienController::class, 'destroyJadwal'])->name('batal_jadwal');
        
        // Pembayaran
        Route::get('/pembayaran', function () { return view('pasien.pembayaran'); })->name('pembayaran'); 
        Route::get('/riwayat-pembayaran', function () { return view('pasien.riwayat-pembayaran'); })->name('riwayat-pembayaran');
        
        // ---> INI RUTE BARU YANG DITAMBAHKAN <---
        Route::get('/pembayaran/detail/{id}', [PasienController::class, 'detailPembayaran'])->name('pembayaran.detail');
        
        // Rekam Medis
        Route::get('/riwayat-rekam-medis', function () {
            $rekamMedis = collect([
                (object) ['id' => 1, 'tanggal' => '12 April 2026', 'dokter' => 'Dr. Fenni', 'diagnosa' => 'Influenza & Demam']
            ]);
            return view('pasien.riwayat-rekam-medis', compact('rekamMedis'));
        })->name('rekam-medis');

        Route::get('/riwayat-rekam-medis/detail/{id}', function ($id) {
            return view('pasien.lihat', ['id' => $id]);
        })->name('rekam-medis.detail');
    });

    // --------------------------------------
    // 4. LOGOUT
    // --------------------------------------
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/'); 
    })->name('logout');

});