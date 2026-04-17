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
