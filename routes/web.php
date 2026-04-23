<?php

use Illuminate\Support\Facades\Route;

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
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::view('/pasien', 'admin.pasien')->name('pasien');
    Route::view('/dokter', 'admin.dokter')->name('dokter');
    Route::view('/jadwal', 'admin.jadwal')->name('jadwal');
    Route::view('/rekam-medis', 'admin.rekam-medis')->name('rekam-medis');
    Route::view('/pembayaran', 'admin.pembayaran')->name('pembayaran');
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
});


Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');