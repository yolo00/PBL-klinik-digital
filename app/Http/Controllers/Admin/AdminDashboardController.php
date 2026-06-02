<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\RekamMedis;
use App\Models\CutiDokter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = today();

        // ── Statistic Cards ────────────────────────────────────
        $totalPasien           = Pasien::count();
        $totalDokter           = Dokter::count();
        $totalJadwalHariIni    = Jadwal::whereDate('tanggal', $today)->count();
        $totalRekamMedis7Hari  = RekamMedis::where('created_at', '>=', now()->subDays(7))->count();

        // ── Jadwal Hari Ini ────────────────────────────────────
        $jadwalHariIni = Jadwal::with(['dokter.user', 'pasien.user'])
            ->whereDate('tanggal', $today)
            ->orderBy('jam')
            ->get();

        // ── Dokter Cuti Hari Ini ───────────────────────────────
        $dokterCutiHariIni = CutiDokter::with('dokter.user')
            ->where('status', 'disetujui')
            ->whereDate('dari_tanggal', '<=', $today)
            ->whereDate('sampai_tanggal', '>=', $today)
            ->get();

        // ── Data Grafik: -range s/d +range hari ──────────────
        // Default range = 7, bisa 1 / 3 / 7
        $range = (int) request('range', 7);
        if (!in_array($range, [1, 3, 7])) {
            $range = 7;
        }

        $startDate = $today->copy()->subDays($range);
        $endDate   = $today->copy()->addDays($range);

        // Hitung jumlah jadwal per hari dalam rentang
        $jadwalPerHari = Jadwal::select(
                DB::raw('DATE(tanggal) as tgl'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get()
            ->keyBy('tgl');

        // Buat array lengkap untuk setiap hari dalam rentang
        $chartLabels = [];
        $chartData   = [];
        $chartColors = [];

        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $dateKey = $current->toDateString();
            $chartLabels[] = $current->translatedFormat('d M');
            $chartData[]   = $jadwalPerHari->has($dateKey) ? $jadwalPerHari[$dateKey]->total : 0;
            // Abu-abu untuk masa lalu, biru untuk hari ini dan mendatang
            $chartColors[] = $current->lt($today) ? '#94a3b8' : '#3b82f6';
            $current->addDay();
        }

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalJadwalHariIni',
            'totalRekamMedis7Hari',
            'jadwalHariIni',
            'dokterCutiHariIni',
            'chartLabels',
            'chartData',
            'chartColors',
            'range'
        ));
    }
}
