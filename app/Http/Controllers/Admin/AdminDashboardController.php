<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\RekamMedis;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalPasien = Pasien::count();
        $totalDokter = Dokter::count();
        $totalJadwalHariIni = Jadwal::whereDate('tanggal', today())->count();
        $totalRekamMedis7Hari = RekamMedis::where('created_at', '>=', now()->subDays(7))->count();

        // Jadwal terbaru untuk quick view (10 terakhir)
        $jadwalTerbaru = Jadwal::with([
                'dokter.user',
                'pasien.user',
            ])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Dokter yang cuti hari ini
        $dokterCutiHariIni = \App\Models\CutiDokter::with('dokter.user')
            ->where('status', 'disetujui')
            ->whereDate('dari_tanggal', '<=', today())
            ->whereDate('sampai_tanggal', '>=', today())
            ->get();

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalJadwalHariIni',
            'totalRekamMedis7Hari',
            'jadwalTerbaru',
            'dokterCutiHariIni'
        ));
    }
}
