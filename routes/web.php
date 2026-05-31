<?php

use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf; // untuk pdf rekam medis

// Admin Routes Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPasienController;
use App\Http\Controllers\Admin\AdminDokterController;
use App\Http\Controllers\Admin\AdminJadwalController;
use App\Http\Controllers\Admin\AdminRekamMedisController;
use App\Http\Controllers\Admin\AdminPembayaranController;
use App\Http\Controllers\Admin\AdminJadwalSistemController;

// Pasien Controller
use App\Http\Controllers\Pasien\PasienController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// RUTE PUBLIK (Tanpa perlu login)
// ==========================================
Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

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
        Route::resource('jadwal', AdminJadwalController::class);
        Route::resource('rekam-medis', AdminRekamMedisController::class);
        Route::resource('pembayaran', AdminPembayaranController::class)
            ->only(['index', 'create', 'store', 'show', 'edit']);

        // Jadwal Sistem & Cuti Dokter
        Route::get('/jadwal-sistem', [AdminJadwalSistemController::class, 'index'])->name('jadwal-sistem');
        Route::post('/cuti-dokter/{id}/terima', [AdminJadwalSistemController::class, 'approve'])->name('cuti-dokter.terima');
        Route::post('/cuti-dokter/{id}/tolak', [AdminJadwalSistemController::class, 'reject'])->name('cuti-dokter.tolak');
        Route::get('/cuti-dokter/{id}', [AdminJadwalSistemController::class, 'show'])->name('cuti-dokter.detail');
    });

    // --------------------------------------
    // 2. DOKTER ROUTES
    // --------------------------------------
    Route::prefix('dokter')->middleware('role:D')->group(function () {
        Route::get('/dashboard', function () { return view('dokter.dashboard-dokter'); })->name('dokter.dashboard');
        Route::get('/jadwal', function () { return view('dokter.jadwal-saya'); })->name('dokter.jadwal');
        Route::get('/pasien', function () { return view('dokter.pasien-dokter'); })->name('dokter.pasien');
        Route::get('/pengaturan-jadwal', function () { return view('dokter.pengaturan-jadwal'); })->name('dokter.pengaturan');
        Route::get('/rekam-medis', function () { return view('dokter.rekam-medis-dokter'); })->name('dokter.rekam-medis');
        Route::get('/rekam-medis/edit/{id}', function ($id) { return view('dokter.edit-rekam-medis', ['id' => $id]); })->name('dokter.edit-rekam');
        Route::get('/profil', function() { return view('dokter.profil-dokter'); })->name('dokter.profil');
    });

    // --------------------------------------
    // 3. PASIEN ROUTES (SUDAH DIPERBARUI DENGAN OOP CONTROLLER & SECURITY ROLE)
    // --------------------------------------
    Route::prefix('pasien')->name('pasien.')->middleware('role:P')->group(function () {
        
        // Rute CRUD OOP menggunakan PasienController
        Route::get('/dashboard', [PasienController::class, 'index'])->name('dashboard');
        
        Route::get('/buat-janji', [PasienController::class, 'buatJanji'])->name('buat-janji');
        Route::post('/buat-janji', [PasienController::class, 'storeJadwal'])->name('store_jadwal');
        
        Route::get('/profil/edit', function () { return view('pasien.edit-profil'); })->name('profil.edit');
        Route::post('/profil/update', [PasienController::class, 'updateProfil'])->name('profil.update');
        
        Route::delete('/jadwal/{id}/batal', [PasienController::class, 'destroyJadwal'])->name('batal_jadwal');

        // Rute Statis Pasien
        Route::get('/riwayat-jadwal', [PasienController::class, 'riwayatJadwal'])->name('riwayat');
        Route::get('/pembayaran', function () { return view('pasien.pembayaran'); })->name('pembayaran'); 
        Route::get('/riwayat-pembayaran', function () { return view('pasien.riwayat-pembayaran'); })->name('riwayat-pembayaran');
        Route::get('/profil', function () { return view('pasien.profil'); })->name('profil');
        
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