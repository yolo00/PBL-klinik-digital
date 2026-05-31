<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. Menampilkan Halaman Login
    public function showLogin()
    {
        return view('login');
    }

    // 2. Memproses Data Login
    public function submit(Request $request)
    {
        // Jika sudah login, hapus sesi lama terlebih dahulu
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Validasi input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Autentikasi mencocokkan email & password dengan isi Database
        if (Auth::attempt($credentials)) {
            // Jika sukses, buat sesi baru agar aman
            $request->session()->regenerate();

            // Arahkan ke dashboard masing-masing sesuai properti yang ada di Model AkunUser
            return redirect()->route(Auth::user()->halaman_beranda);
        }

        // Jika gagal login (email/password salah), kembalikan ke halaman login
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['login' => 'Email atau kata sandi salah.']);
    }

    // 3. Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}