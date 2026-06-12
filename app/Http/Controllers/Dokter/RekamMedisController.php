<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RekamMedisController extends Controller
{
    /**
     * Daftar SEMUA rekam medis milik dokter yang sedang login.
     */
    public function index()
    {
        $dokterId = auth()->user()->dokter->id;

        // Ambil rekam medis hanya milik dokter ini via jadwal
        $rekamMedis = RekamMedis::whereHas('jadwal', function ($q) use ($dokterId) {
            $q->where('id_dokter', $dokterId);
        })
        ->with(['jadwal.pasien.user', 'jadwal.dokter.user'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('dokter.riwayat-rekam', compact('rekamMedis'));
    }

    /**
     * Detail satu rekam medis.
     * BUG FIX: route dokter.rekam.show harus mengarah ke method ini, bukan riwayat()
     */
    public function show($id)
    {
        $rekamMedis = RekamMedis::with([
            'jadwal.pasien.user',
            'jadwal.dokter.user',
            'reseps',
        ])->findOrFail($id);

        return view('dokter.detail-rekam-medis', compact('rekamMedis'));
    }

    /**
     * Riwayat rekam medis untuk SATU pasien tertentu.
     */
    public function riwayat($id)
    {
        $pasien = Pasien::with('user')->findOrFail($id);

        $dokterId = auth()->user()->dokter->id;

        $rekamMedis = RekamMedis::whereHas('jadwal', function ($q) use ($id, $dokterId) {
            $q->where('id_pasien', $id)
              ->where('id_dokter', $dokterId);
        })
        ->with(['jadwal.dokter.user'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('dokter.riwayat-rekam-medis', compact('pasien', 'rekamMedis'));
    }

    /**
     * Export rekam medis ke PDF (fitur wajib yang sebelumnya tidak ada).
     * Membutuhkan package: composer require barryvdh/laravel-dompdf
     */
    public function exportPdf($id)
    {
        $rekamMedis = RekamMedis::with([
            'jadwal.pasien.user',
            'jadwal.dokter.user',
            'reseps',
        ])->findOrFail($id);

        // Pastikan hanya dokter yang menangani yang bisa export
        $dokterId = auth()->user()->dokter->id;
        if ($rekamMedis->jadwal->id_dokter !== $dokterId) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $pdf = Pdf::loadView('dokter.pdf.rekam-medis-pdf', compact('rekamMedis'))
                  ->setPaper('a4', 'portrait');

        $namaPasien = str_replace(' ', '_', $rekamMedis->jadwal->pasien->user->nama ?? 'pasien');
        $filename   = 'rekam_medis_' . $namaPasien . '_' . $rekamMedis->id . '.pdf';

        return $pdf->download($filename);
    }
}