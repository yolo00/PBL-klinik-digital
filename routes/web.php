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
Route::prefix('dokter')->name('dokter.')->group(function () {
    Route::view('/dashboard-dokter', 'dokter.dashboard-dokter')->name('dashboard-dokter');
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