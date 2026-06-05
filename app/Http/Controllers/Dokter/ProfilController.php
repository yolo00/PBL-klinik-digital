<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dokter = $user->dokter;

        // Ambil data spesialisasi
        $spesialisasiRaw = $dokter->spesialisasi;
        
        // Cek apakah datanya berbentuk JSON string
        $spesialisDisplay = $spesialisasiRaw;
        if ($decoded = json_decode($spesialisasiRaw, true)) {
            // Jika JSON, ambil bagian 'nama'
            $spesialisDisplay = $decoded['nama'] ?? 'Tidak diketahui';
        }

        return view('dokter.profil-dokter', compact('dokter', 'spesialisDisplay'));
    }
}