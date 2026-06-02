<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekamMedis;

class RekamMedisController extends Controller
{
    public function index()
    {
        // Pastikan relasi 'pasien' sudah didefinisikan di Model RekamMedis
        $rekamMedis = RekamMedis::with('pasien')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('dokter.rekam-medis', compact('rekamMedis'));
    }
}