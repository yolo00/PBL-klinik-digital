<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function submit(Request $request)
    {
        // Jika sudah login, hapus sesi lama terlebih dahulu
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $request->validate([
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email|unique:akun_user,email',
            'tgl_lahir'     => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'required|string|max:15',
            'gol_darah'     => 'nullable|in:A,B,AB,O',
            'password'      => 'required|min:6|confirmed',
        ], [
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'tgl_lahir.required'     => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'no_hp.required'         => 'Nomor HP wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        DB::transaction(function () use ($request) {
            // Insert ke akun_user, dapatkan id yang baru dibuat
            $userId = DB::table('akun_user')->insertGetId([
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'nama'          => $request->nama,
                'no_hp'         => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tgl_lahir'     => $request->tgl_lahir,
                'role'          => 'P',
                'created_at'    => now(),
            ]);

            // Insert ke pasien dengan field baru (gol_darah)
            DB::table('pasien')->insert([
                'id_user'   => $userId,
                'gol_darah' => $request->gol_darah,
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan masuk dengan akun baru Anda.');
    }
}
