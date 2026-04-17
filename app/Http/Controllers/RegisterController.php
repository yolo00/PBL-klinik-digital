<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:akun_user,email',
            'nimnik' => 'required|string|max:20',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|string|max:15',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $userId = DB::table('akun_user')->insertGetId([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tgl_lahir' => $request->tgl_lahir,
                'role' => 'P',
                'created_at' => now()
            ]);

            DB::table('pasien')->insert([
                'id_user' => $userId,
                'nimnik' => $request->nimnik,
            ]);
        });

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk dengan akun baru Anda.');
    }
}
