<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    /**
     * Tampilkan semua jadwal dokter yang sedang login.
     * Sebelumnya class ini memanggil 'DokterPasienController' di route
     * yang tidak pernah di-import → error fatal.
     * Sekarang JadwalController menangani sendiri route dokter.jadwal.
     */
    public function index()
    {
        $dokterId = auth()->user()->dokter->id;

        $jadwals = Jadwal::with(['pasien.user'])
            ->where('id_dokter', $dokterId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'asc')
            ->get();

        return view('dokter.jadwal-saya', compact('jadwals'));
    }
}