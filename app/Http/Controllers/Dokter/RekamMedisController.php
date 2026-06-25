<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;

class RekamMedisController extends Controller
{
    /**
     * Skenario: Melihat Rekam Medis Pasien — daftar semua
     */
    public function index(Request $request)
    {
        $dokterId = auth()->user()->dokter->id;
        $search   = $request->input('search', '');

        $rekamMedis = RekamMedis::whereHas('jadwal', function ($q) use ($dokterId) {
                $q->where('id_dokter', $dokterId);
            })
            ->with(['jadwal.pasien.user', 'jadwal.dokter.user'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('diagnosa', 'like', "%{$search}%")
                        ->orWhere('keluhan', 'like', "%{$search}%")
                        ->orWhereHas('jadwal.pasien.user', function ($u) use ($search) {
                            $u->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('dokter.riwayat-rekam', compact('rekamMedis', 'search'));
    }

    /**
     * Skenario: Melihat Rekam Medis Pasien — detail lengkap
     * - Tampilkan informasi kesehatan pasien secara detail
     * - Termasuk resep, diagnosa, keluhan, tindakan
     */
    public function show($id)
    {
        $rekamMedis = RekamMedis::with([
            'jadwal.pasien.user',
            'jadwal.pasien.alergi',
            'jadwal.dokter.user',
            'jadwal.dokter.spesialisasi',
            'resep',
            'createdBy',
        ])->findOrFail($id);

        // Pastikan hanya dokter yang menangani yang bisa lihat
        $dokterId = auth()->user()->dokter->id;
        if ((int)$rekamMedis->jadwal->id_dokter !== (int)$dokterId) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        return view('dokter.detail-rekam-medis', compact('rekamMedis'));
    }

    /**
     * Skenario: Melihat riwayat rekam medis per pasien
     */
    public function riwayat(Request $request, $id)
    {
        $dokterId = auth()->user()->dokter->id;
        $pasien   = Pasien::with('user')->findOrFail($id);
        $search   = $request->input('search', '');

        $rekamMedis = RekamMedis::whereHas('jadwal', function ($q) use ($id, $dokterId) {
                $q->where('id_pasien', $id)->where('id_dokter', $dokterId);
            })
            ->with(['jadwal.dokter.user'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('diagnosa', 'like', "%{$search}%")
                        ->orWhere('keluhan', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8)
            ->withQueryString();

        return view('dokter.riwayat-rekam-medis', compact('pasien', 'rekamMedis', 'search'));
    }

    /**
     * Skenario: Export Resep PDF
     * - Data resep tersedia → sistem membuat file PDF
     * - File diunduh dengan nama yang sesuai
     */
    public function exportPdf($id)
    {
        $rekamMedis = RekamMedis::with([
            'jadwal.pasien.user',
            'jadwal.pasien.alergi',
            'jadwal.dokter.user',
            'jadwal.dokter.spesialisasi',
            'resep',
        ])->findOrFail($id);

        $dokterId = auth()->user()->dokter->id;

        // Hanya dokter yang menangani yang bisa export
        if ((int)$rekamMedis->jadwal->id_dokter !== (int)$dokterId) {
            abort(403, 'Anda tidak memiliki akses untuk mengekspor rekam medis ini.');
        }

        // Catatan requirement: saat PDF diekspor, gunakan tanggal & jam ketika rekam medis diisi.
        // Saat ini menggunakan timestamp rekam_medis.created_at.
        $pdf = Pdf::loadView('dokter.pdf.rekam-medis-pdf', compact('rekamMedis'))
                  ->setPaper('a4', 'portrait');


        $namaPasien = str_replace(' ', '_', $rekamMedis->jadwal->pasien->user->nama ?? 'pasien');
        $tanggal    = now()->format('Ymd');
        $filename   = 'rekam_medis_' . $namaPasien . '_' . $tanggal . '_' . $rekamMedis->id . '.pdf';

        return $pdf->download($filename);
    }
}
