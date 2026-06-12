<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;

class ProfilController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $dokter = $user->dokter;

        // Proses spesialisasi
        $spesialisDisplay = 'Dokter Umum';

        if ($dokter && $dokter->spesialisasi) {
            // Jika relasi spesialisasi (object), ambil nama-nya
            if ($dokter->relationLoaded('spesialisasi') || $dokter->spesialisasi instanceof \App\Models\Spesialisasi) {
                $spesialisDisplay = $dokter->spesialisasi->nama ?? 'Dokter Umum';
            } else {
                // Fallback jika tersimpan sebagai string/JSON
                $decoded = json_decode($dokter->spesialisasi, true);
                if (is_array($decoded) && isset($decoded['nama'])) {
                    $spesialisDisplay = $decoded['nama'];
                } else {
                    $spesialisDisplay = $dokter->spesialisasi;
                }
            }
        }

        // BUG FIX: load relasi spesialisasi agar tidak lazy-load di view
        $dokter->load('spesialisasi');

        return view('dokter.profil-dokter', compact('user', 'dokter', 'spesialisDisplay'));
    }
}