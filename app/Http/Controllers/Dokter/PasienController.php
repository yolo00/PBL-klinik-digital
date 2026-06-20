<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Resep;

class PasienController extends Controller
{
    /**
     * Skenario: Melihat Daftar Pasien
     * - Tampilkan pasien sesuai jadwal konsultasi dokter
     * - Data booking pasien tersedia → tampilkan daftar
     */
    public function index(Request $request)
    {
        $dokterId = auth()->user()->dokter->id;
        $search   = $request->input('search', '');

        $pasiens = Pasien::whereHas('jadwals', function ($q) use ($dokterId) {
                $q->where('id_dokter', $dokterId);
            })
            ->with('user')
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('nama', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        return view('dokter.pasien-dokter', compact('pasiens', 'search'));
    }

    /**
     * Skenario: Mengisi Rekam Medis
     * - Buka form input rekam medis
     * - Load data jadwal + pasien + alergi + dokter
     */
    public function buatRekam($id)
    {
        $jadwal = Jadwal::with([
            'pasien.user',
            'pasien.alergi',
            'dokter.user',
            'rekamMedis', // cek apakah sudah ada rekam medis
        ])->findOrFail($id);

        $dokterId = auth()->user()->dokter->id;

        // Pastikan jadwal ini milik dokter yang login
        if ((int)$jadwal->id_dokter !== (int)$dokterId) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }

        // Jika rekam medis sudah ada, redirect ke halaman detail
        if ($jadwal->rekamMedis) {
            return redirect()
                ->route('dokter.rekam.show', $jadwal->rekamMedis->id)
                ->with('info', 'Rekam medis untuk jadwal ini sudah diisi sebelumnya.');
        }

        return view('dokter.edit-rekam-medis', compact('jadwal'));
    }

    /**
     * Skenario: Mengisi Rekam Medis — Simpan
     * - Validasi: keluhan dan diagnosa WAJIB diisi
     * - Jika diagnosa kosong → tampilkan validasi error
     * - Simpan data + resep ke database
     * - Update status jadwal menjadi selesai
     */
    public function storeRekamMedis(Request $request, $id)
    {
        $jadwal   = Jadwal::findOrFail($id);
        $dokterId = auth()->user()->dokter->id;

        if ((int)$jadwal->id_dokter !== (int)$dokterId) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }

        // Skenario: Validasi — diagnosa wajib diisi
        $request->validate([
            'keluhan'  => 'required|string|min:3',
            'diagnosa' => 'required|string|min:3',
            'tindakan' => 'nullable|string',
            'catatan'  => 'nullable|string',
            'resep'    => 'nullable|array',
            'resep.*.obat'         => 'nullable|string|max:255',
            'resep.*.dosis'        => 'nullable|string|max:100',
            'resep.*.aturan_pakai' => 'nullable|string|max:255',
        ], [
            'keluhan.required'  => 'Keluhan pasien wajib diisi.',
            'keluhan.min'       => 'Keluhan terlalu singkat, minimal 3 karakter.',
            'diagnosa.required' => 'Diagnosis dokter wajib diisi.',
            'diagnosa.min'      => 'Diagnosis terlalu singkat, minimal 3 karakter.',
        ]);

        // Simpan rekam medis
        $rekam = RekamMedis::create([
            'id_jadwal'  => $jadwal->id,
            'keluhan'    => $request->keluhan,
            'diagnosa'   => $request->diagnosa,
            'tindakan'   => $request->tindakan,
            'catatan'    => $request->catatan,
            'created_by' => auth()->id(),
        ]);

        // Skenario: Mengisi Resep — simpan tiap baris resep yang terisi
        if ($request->has('resep') && is_array($request->resep)) {
            foreach ($request->resep as $item) {
                if (empty(trim($item['obat'] ?? ''))) continue;
                Resep::create([
                    'id_rekam'     => $rekam->id,
                    'obat'         => trim($item['obat']),
                    'dosis'        => trim($item['dosis'] ?? ''),
                    'aturan_pakai' => trim($item['aturan_pakai'] ?? ''),
                ]);
            }
        }

        // Update status jadwal → selesai
        $jadwal->update(['status' => 'selesai']);

        return redirect()
            ->route('dokter.rekam.show', $rekam->id)
            ->with('success', 'Rekam medis dan resep berhasil disimpan!');
    }
}
