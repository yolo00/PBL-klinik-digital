<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\RekamMedis;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Skenario: Login dengan akun valid → cek relasi dokter ada
        if (!$user->dokter) {
            return redirect()->route('login')
                ->with('error', 'Akun ini tidak terdaftar sebagai dokter.');
        }

        $dokterId = $user->dokter->id;
        $today    = now()->toDateString();

        // Skenario: Melihat jadwal hari ini
        $jadwalHariIni = Jadwal::where('id_dokter', $dokterId)
            ->whereDate('tanggal', $today)
            ->count();

        // Skenario: Semua jadwal
        $semuaJadwal = Jadwal::where('id_dokter', $dokterId)->count();

        // Skenario: Rekam medis yang belum terisi (jadwal dikonfirmasi/menunggu tapi belum ada rekam medis)
        $rekamBelumTerisi = Jadwal::where('id_dokter', $dokterId)
            ->whereIn('status', ['dikonfirmasi', 'menunggu'])
            ->whereDoesntHave('rekamMedis')
            ->count();

        // Skenario: Jadwal hari ini untuk ditampilkan di tabel dashboard
        $jadwalList = Jadwal::with(['pasien.user'])
            ->where('id_dokter', $dokterId)
            ->whereDate('tanggal', $today)
            ->orderBy('jam', 'asc')
            ->get();

        return view('dokter.dashboard-dokter', compact(
            'jadwalHariIni',
            'semuaJadwal',
            'rekamBelumTerisi',
            'jadwalList'
        ));
    }
}
