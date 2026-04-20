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
Route::prefix('dokter')->name('dokter.')->group(function () {
    // 'dokter.dashboard-dokter' merujuk ke folder 'dokter' dan file 'dashboard-dokter'
    Route::view('/dashboard-dokter', 'dokter.dashboard-dokter')->name('dashboard-dokter');
});
