<?php

use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf; //untuk pdf rekam medis

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'home')->name('home');
Route::view('/login', 'login')->name('login');
Route::view('/about', 'about')->name('about'); //incase kalian belum up to date
Route::view('/contact', 'contact')->name('contact'); //incase kalian belum up to date
Route::view('/register', 'register')->name('register');
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'submit'])->name('register.submit');

// Admin Routes
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPasienController;
use App\Http\Controllers\Admin\AdminDokterController;
use App\Http\Controllers\Admin\AdminJadwalController;
use App\Http\Controllers\Admin\AdminRekamMedisController;
use App\Http\Controllers\Admin\AdminPembayaranController;
use App\Http\Controllers\Admin\AdminJadwalSistemController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('pasien', AdminPasienController::class)
        ->only(['index', 'create', 'store', 'show', 'edit']);

    Route::resource('dokter', AdminDokterController::class)
        ->only(['index', 'create', 'store', 'show', 'edit']);

    Route::resource('jadwal', AdminJadwalController::class)
        ->only(['index', 'create', 'store', 'show', 'edit']);

    Route::resource('rekam-medis', AdminRekamMedisController::class)
        ->only(['index', 'create', 'store', 'show', 'edit'])
        ->parameters(['rekam-medis' => 'rekamMedis']);

    Route::resource('pembayaran', AdminPembayaranController::class)
        ->only(['index', 'create', 'store', 'show', 'edit']);

    // Jadwal Sistem & Cuti Dokter
    Route::get('/jadwal-sistem', [AdminJadwalSistemController::class, 'index'])->name('jadwal-sistem');
    Route::post('/cuti-dokter/{id}/terima', [AdminJadwalSistemController::class, 'approve'])->name('cuti-dokter.terima');
    Route::post('/cuti-dokter/{id}/tolak', [AdminJadwalSistemController::class, 'reject'])->name('cuti-dokter.tolak');
    Route::get('/cuti-dokter/{id}', [AdminJadwalSistemController::class, 'show'])->name('cuti-dokter.detail');
});

//Route Dokter
// Rute khusus untuk akses Dokter
Route::prefix('dokter')->group(function () {

    // Halaman Utama Dashboard
    Route::get('/dashboard', function () {
        return view('dokter.dashboard-dokter');
    })->name('dokter.dashboard');

    // Halaman Jadwal Harian
    Route::get('/jadwal', function () {
        return view('dokter.jadwal-saya');
    })->name('dokter.jadwal');

    // Halaman Data Pasien Khusus Dokter
    Route::get('/pasien', function () {
        return view('dokter.pasien-dokter');
    })->name('dokter.pasien');

    // Halaman Pengaturan Operasional & Cuti
    Route::get('/pengaturan-jadwal', function () {
        return view('dokter.pengaturan-jadwal');
    })->name('dokter.pengaturan');

    // Halaman Riwayat Rekam Medis
    Route::get('/rekam-medis', function () {
        return view('dokter.rekam-medis-dokter');
    })->name('dokter.rekam-medis');

    Route::get('/rekam-medis/edit/{id}', function ($id) {
        return view('dokter.edit-rekam-medis', ['id' => $id]);
    })->name('dokter.edit-rekam');

    Route::get('/profil', function() { 
        return view('dokter.profil-dokter'); 
    })->name('dokter.profil');

});


// Routes Pasien
Route::prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('dashboard');

    Route::get('/buat-janji', function () {
        return view('pasien.buat-janji');
    })->name('buat-janji');

    Route::get('/riwayat-jadwal', function () {
        return view('pasien.riwayat-jadwal');
    })->name('riwayat');
   Route::get('/pembayaran', function () {
        return view('pasien.pembayaran');
    })->name('pembayaran'); 
    Route::get('/riwayat-pembayaran', function () {
        return view('pasien.riwayat-pembayaran');
    })->name('riwayat-pembayaran');
});
// Pindahkan keluar dari area routes pasien, karena tidak mau kebaca routenya
// 1. Route untuk HALAMAN DAFTAR (Menampilkan Tabel)
Route::get('/pasien/riwayat-rekam-medis', function () {
    // Data dummy untuk isi tabel
    $rekamMedis = collect([
        (object) ['id' => 1, 'tanggal' => '12 April 2026', 'dokter' => 'Dr. Fenni', 'diagnosa' => 'Influenza & Demam'],
        (object) ['id' => 2, 'tanggal' => '28 Maret 2026', 'dokter' => 'Dr. Andi', 'diagnosa' => 'Gastritis Akut'],
        (object) ['id' => 3, 'tanggal' => '15 Februari 2026', 'dokter' => 'Dr. Siti', 'diagnosa' => 'Scaling Gigi'],
        (object) ['id' => 4, 'tanggal' => '10 Januari 2026', 'dokter' => 'Dr. Budi', 'diagnosa' => 'Hipertensi'],
        (object) ['id' => 5, 'tanggal' => '22 Desember 2025', 'dokter' => 'Dr. Fenni', 'diagnosa' => 'Cek Rutin Pasca Flu'],
        (object) ['id' => 6, 'tanggal' => '05 November 2025', 'dokter' => 'Dr. Andi', 'diagnosa' => 'Radang Tenggorokan']
    ]);

    return view('pasien.riwayat-rekam-medis', compact('rekamMedis'));
})->name('pasien.rekam-medis');

// 2. Route untuk HALAMAN DETAIL (Dibutuhkan saat klik tombol "Lihat Detail")
Route::get('/pasien/riwayat-rekam-medis/detail/{id}', function ($id) {
    // Variabel $id ini yang akan menangkap angka 1, 2, atau 3 dari URL
    return view('pasien.lihat', ['id' => $id]);
})->name('pasien.rekam-medis.detail');


Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); 
})->name('logout');

Route::get('/pasien/rekam-medis/export-pdf', function () {
    // Sementara pakai data statis dulu agar muncul hasilnya
    $data = [
        'no_rm' => '#00164',
        'dokter' => 'Dr. Fenni',
        'tanggal' => '12 April 2026',
        'keluhan' => 'Pasien merasa hangat dan meriang sejak 2 hari yang lalu, disertai batuk ringan.',
        'diagnosa' => 'Demam Ringan (Influenza awal)',
        'resep' => [
            'Paracetamol 500mg (3x1 hari setelah makan)',
            'Vitamin C, 1 tablet setiap hari'
        ]
    ];

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pasien.pdf-rekam-medis', $data);
    return $pdf->download('Rekam-Medis-UniHealth.pdf');
})->name('pasien.rekam-medis.pdf');