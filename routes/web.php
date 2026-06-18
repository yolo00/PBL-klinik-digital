<?php

use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

// Home
use App\Http\Controllers\HomeController;

// Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPasienController;
use App\Http\Controllers\Admin\AdminDokterController;
use App\Http\Controllers\Admin\AdminJadwalController;
use App\Http\Controllers\Admin\AdminRekamMedisController;
use App\Http\Controllers\Admin\AdminPembayaranController;
use App\Http\Controllers\Admin\AdminJadwalSistemController;
use App\Http\Controllers\Admin\AdminJadwalDokterController;
use App\Http\Controllers\Admin\AdminSpesialisasiController;
// Dokter
use App\Http\Controllers\Dokter\DashboardController;
use App\Http\Controllers\Dokter\JadwalController;
use App\Http\Controllers\Dokter\PasienController as DokterPasienController;
use App\Http\Controllers\Dokter\RekamMedisController;
use App\Http\Controllers\Dokter\ProfilController;

// Pasien
use App\Http\Controllers\Pasien\PasienController;

//Pembayaran
use App\Http\Controllers\Pasien\XenditController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//Webhook Xendit
Route::post('/xendit/callback', [XenditController::class, 'callback'])
    ->name('xendit.callback');

//Home/Landing pages
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'submit'])->name('login.submit');
Route::view('/register', 'register')->name('register');
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'submit'])->name('register.submit');

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
        Route::resource('spesialisasi', AdminSpesialisasiController::class);

        Route::get('/jadwal-sistem', [AdminJadwalSistemController::class, 'index'])->name('jadwal-sistem');
        Route::get('/jadwal-sistem/harian/{jadwalSistem}/edit', [AdminJadwalSistemController::class, 'editHarian'])->name('jadwal-sistem.harian.edit');
        Route::put('/jadwal-sistem/harian/{jadwalSistem}', [AdminJadwalSistemController::class, 'updateHarian'])->name('jadwal-sistem.harian.update');
        Route::get('/jadwal-sistem/create', [AdminJadwalSistemController::class, 'create'])->name('jadwal-sistem.create');
        Route::post('/jadwal-sistem', [AdminJadwalSistemController::class, 'store'])->name('jadwal-sistem.store');
        Route::get('/jadwal-sistem/{jadwalSistem}/edit', [AdminJadwalSistemController::class, 'edit'])->name('jadwal-sistem.edit');
        Route::put('/jadwal-sistem/{jadwalSistem}', [AdminJadwalSistemController::class, 'update'])->name('jadwal-sistem.update');
        Route::delete('/jadwal-sistem/{jadwalSistem}', [AdminJadwalSistemController::class, 'destroy'])->name('jadwal-sistem.destroy');
    });

    // --------------------------------------
    // 2. DOKTER ROUTES
    // --------------------------------------
    Route::prefix('dokter')->middleware('role:D')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dokter.dashboard');
        Route::get('/profil', [ProfilController::class, 'index'])->name('dokter.profil');
        Route::get('/pengaturan-jadwal', function () {
            return view('dokter.pengaturan-jadwal');
        })->name('dokter.pengaturan');
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('dokter.jadwal');
        Route::get('/jadwal/{id}/buat-rekam', [DokterPasienController::class, 'buatRekam'])->name('dokter.jadwal.buat-rekam');
        Route::post('/jadwal/{id}/simpan-rekam', [DokterPasienController::class, 'storeRekamMedis'])->name('dokter.rekam-medis.store');
        Route::get('/pasien', [DokterPasienController::class, 'index'])->name('dokter.pasien');
        Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('dokter.rekam-medis');
        Route::get('/rekam-medis/{id}', [RekamMedisController::class, 'show'])->name('dokter.rekam.show');
        Route::get('/rekam-medis/{id}/export-pdf', [RekamMedisController::class, 'exportPdf'])->name('dokter.rekam.export-pdf');
        Route::get('/pasien/{id}/riwayat', [RekamMedisController::class, 'riwayat'])->name('dokter.rekam.riwayat');
    });

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
        Route::get('/get-dokter/{id_spesialisasi}', [PasienController::class, 'getDokterBySpesialisasi'])->name('get-dokter');

        // Pembayaran
        Route::get('/pembayaran/{id}/qris',      [XenditController::class, 'showQris'])        ->name('pembayaran.qris');
        Route::get('/pembayaran/{id}/status',    [XenditController::class, 'cekStatus'])       ->name('pembayaran.status');
        Route::post('/pembayaran/{id}/konfirmasi',[XenditController::class, 'konfirmasiManual'])->name('pembayaran.konfirmasi');
        Route::get('/pembayaran/{id}/struk',     [XenditController::class, 'struk'])           ->name('pembayaran.struk');
        Route::get('/get-harga-dokter/{id_dokter}', [PasienController::class, 'getHargaDokter'])->name('get-harga-dokter');

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