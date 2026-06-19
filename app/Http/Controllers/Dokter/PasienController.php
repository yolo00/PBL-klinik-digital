<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\RekamMedis;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $dokterId = auth()->user()->dokter->id;
        $search   = $request->input('search', '');

        $pasiens = Pasien::whereHas('jadwals', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->with('user')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString(); // agar search ikut di link pagination

        return view('dokter.pasien-dokter', compact('pasiens', 'search'));
    }

    public function buatRekam($id)
    {
        $jadwal   = Jadwal::with(['pasien.user', 'pasien.alergi', 'dokter.user'])->findOrFail($id);
        $dokterId = auth()->user()->dokter->id;

        if ($jadwal->id_dokter !== $dokterId) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('dokter.edit-rekam-medis', compact('jadwal'));
    }

    public function storeRekamMedis(Request $request, $id)
    {
        $jadwal   = Jadwal::findOrFail($id);
        $dokterId = auth()->user()->dokter->id;

        if ($jadwal->id_dokter !== $dokterId) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $request->validate([
            'keluhan'  => 'required|string',
            'diagnosa' => 'required|string',
        ]);

        $rekam = \App\Models\RekamMedis::create([
            'id_jadwal'  => $jadwal->id,
            'keluhan'    => $request->keluhan,
            'diagnosa'   => $request->diagnosa,
            'tindakan'   => $request->tindakan,
            'catatan'    => $request->catatan,
            'created_by' => auth()->id(),
        ]);

        if ($request->has('resep')) {
            foreach ($request->resep as $item) {
                if (empty($item['obat'])) continue;
                \App\Models\Resep::create([
                    'id_rekam'     => $rekam->id,
                    'obat'         => $item['obat'],
                    'dosis'        => $item['dosis'] ?? null,
                    'aturan_pakai' => $item['aturan_pakai'] ?? null,
                ]);
            }
        }

        $jadwal->update(['status' => 'selesai']);

        return redirect()->route('dokter.jadwal')->with('success', 'Rekam medis berhasil disimpan!');
    }
}