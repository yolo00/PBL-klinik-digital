<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\RekamMedis;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Pastikan relasi 'dokter' sudah terdefinisi di User model
        if (!$user->dokter) {
            return back()->with('error', 'Profil dokter tidak ditemukan.');
        }
        
        $dokterId = $user->dokter->id;
        $today = date('Y-m-d');
    
        // Menggunakan query yang akurat
        $jadwalHariIni = \App\Models\Jadwal::where('id_dokter', $dokterId)
                                           ->whereDate('tanggal', $today)
                                           ->count();
    
        $semuaJadwal = \App\Models\Jadwal::where('id_dokter', $dokterId)->count();
    
        // Rekam belum terisi (asumsi: jadwal statusnya 'dikonfirmasi' tapi belum selesai)
        $rekamBelumTerisi = \App\Models\Jadwal::where('id_dokter', $dokterId)
                                               ->where('status', 'dikonfirmasi') 
                                               ->count();
    
        $jadwalList = \App\Models\Jadwal::with(['pasien.user'])
                            ->where('id_dokter', $dokterId)
                            ->whereDate('tanggal', $today)
                            ->orderBy('jam', 'asc')
                            ->get();
    
                            return view('dokter.dashboard-dokter', compact('jadwalHariIni', 'semuaJadwal', 'rekamBelumTerisi', 'jadwalList'));
    }
}