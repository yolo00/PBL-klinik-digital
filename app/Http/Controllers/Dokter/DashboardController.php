<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\RekamMedis;

class DashboardController extends Controller
{
    // Di dalam DashboardController.php
    public function index()
    {
        $dokterId = auth()->user()->dokter->id;
        
        $data = [
            'jadwalHariIni' => Jadwal::where('id_dokter', $dokterId)->whereDate('tanggal', date('Y-m-d'))->count(),
            'semuaJadwal'   => Jadwal::where('id_dokter', $dokterId)->count(),
            'rekamBelumTerisi' => Jadwal::where('id_dokter', $dokterId)->where('status', 'dikonfirmasi')->count(),
        ];

        $jadwalList = Jadwal::where('id_dokter', $dokterId)->whereDate('tanggal', date('Y-m-d'))->with('pasien.user')->get();

        return view('dokter.dashboard-dokter', compact('data', 'jadwalList'));
    }
}