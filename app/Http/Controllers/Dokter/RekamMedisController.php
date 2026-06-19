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
     * Semua rekam medis dokter ini dengan SEARCH + PAGINATION
     */
    public function index(Request $request)
    {
        $dokterId = auth()->user()->dokter->id;
        $search   = $request->input('search');

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
     * Detail satu rekam medis
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
     * Riwayat rekam medis satu pasien dengan SEARCH + PAGINATION
     */
    public function riwayat(Request $request, $id)
    {
        $dokterId = auth()->user()->dokter->id;
        $pasien   = Pasien::with('user')->findOrFail($id);
        $search   = $request->input('search');

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
     * Export PDF
     */
    public function exportPdf($id)
    {
        $rekamMedis = RekamMedis::with([
            'jadwal.pasien.user',
            'jadwal.dokter.user',
            'reseps',
        ])->findOrFail($id);

        $dokterId = auth()->user()->dokter->id;
        if ($rekamMedis->jadwal->id_dokter !== $dokterId) abort(403);

        $pdf = Pdf::loadView('dokter.pdf.rekam-medis-pdf', compact('rekamMedis'))
                  ->setPaper('a4', 'portrait');

        $nama     = str_replace(' ', '_', $rekamMedis->jadwal->pasien->user->nama ?? 'pasien');
        $filename = 'rekam_medis_' . $nama . '_' . $rekamMedis->id . '.pdf';

        return $pdf->download($filename);
    }
}
