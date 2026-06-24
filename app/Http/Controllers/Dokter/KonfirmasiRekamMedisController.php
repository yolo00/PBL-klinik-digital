<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\RekamMedis;
use App\Models\Resep;
use Illuminate\Http\Request;

class KonfirmasiRekamMedisController extends Controller
{
    public function preview(Request $request, $jadwalId)
    {
        $jadwal = Jadwal::with(['pasien.user', 'pasien.alergi', 'dokter.user', 'rekamMedis'])->findOrFail($jadwalId);
        $dokterId = auth()->user()->dokter->id;

        if ((int) $jadwal->id_dokter !== (int) $dokterId) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }

        // Jika sudah final, jangan izinkan konfirmasi lagi.
        if ($jadwal->rekamMedis && (bool) $jadwal->rekamMedis->is_final) {
            abort(403, 'Rekam medis sudah dikonfirmasi dan tidak dapat diubah.');
        }

        // Validasi window akses (hari ini, kemarin, atau sudah lewat)
        $today = now()->toDateString();
        $jadwalTanggal = $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->toDateString() : null;
        if ($jadwalTanggal === null) {
            abort(403, 'Jadwal tidak memiliki tanggal yang valid.');
        }

        $allowed = (
            $jadwalTanggal === $today ||
            $jadwalTanggal === \Carbon\Carbon::parse($today)->subDay()->toDateString() ||
            \Carbon\Carbon::parse($jadwalTanggal)->lt(\Carbon\Carbon::parse($today))
        );

        if (!$allowed) {
            abort(403, 'Rekam medis hanya bisa diisi pada hari ini, kemarin, atau jadwal yang sudah berlalu.');
        }


        // Validasi window akses (hari ini, kemarin, atau sudah lewat)
        $today = now()->toDateString();
        $jadwalTanggal = $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->toDateString() : null;
        if ($jadwalTanggal === null) {
            abort(403, 'Jadwal tidak memiliki tanggal yang valid.');
        }

        $allowed = (
            $jadwalTanggal === $today ||
            $jadwalTanggal === \Carbon\Carbon::parse($today)->subDay()->toDateString() ||
            \Carbon\Carbon::parse($jadwalTanggal)->lt(\Carbon\Carbon::parse($today))
        );

        if (!$allowed) {
            abort(403, 'Rekam medis hanya bisa diisi pada hari ini, kemarin, atau jadwal yang sudah berlalu.');
        }


        // Validasi minimal sebelum preview
        $validated = $request->validate([
            'keluhan'  => 'required|string|min:3',
            'diagnosa' => 'required|string|min:3',
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

        $resep = $validated['resep'] ?? [];

        return view('dokter.konfirmasi-rekam-medis', [
            'jadwal' => $jadwal,
            'keluhan' => $validated['keluhan'] ?? null,
            'diagnosa' => $validated['diagnosa'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
            'resep' => $resep,
        ]);
    }

    public function konfirmasi(Request $request, $jadwalId)
    {
        $jadwal = Jadwal::with(['rekamMedis'])->findOrFail($jadwalId);
        $dokterId = auth()->user()->dokter->id;

        if ((int) $jadwal->id_dokter !== (int) $dokterId) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }

        $validated = $request->validate([
            'keluhan'  => 'required|string|min:3',
            'diagnosa' => 'required|string|min:3',
            'catatan'  => 'nullable|string',
            'resep'    => 'nullable|array',
            'resep.*.obat'         => 'nullable|string|max:255',
            'resep.*.dosis'        => 'nullable|string|max:100',
            'resep.*.aturan_pakai' => 'nullable|string|max:255',
        ]);

        if ($jadwal->rekamMedis && (bool) $jadwal->rekamMedis->is_final) {
            abort(403, 'Rekam medis sudah dikonfirmasi dan tidak dapat diubah.');
        }

        // Buat atau update rekam medis sebagai final
        $rekam = $jadwal->rekamMedis ?: RekamMedis::create([
            'id_jadwal'  => $jadwal->id,
            'created_by' => auth()->id(),
        ]);

        $rekam->update([
            'keluhan' => $validated['keluhan'],
            'diagnosa' => $validated['diagnosa'],
            'catatan' => $validated['catatan'] ?? null,
            'is_final' => true,
            'updated_by' => auth()->id(),
        ]);

        // Reset resep (jika ada) lalu simpan lagi
        $rekam->resep()->delete();

        $resep = $validated['resep'] ?? [];
        if (is_array($resep)) {
            foreach ($resep as $item) {
                if (empty(trim($item['obat'] ?? ''))) {
                    continue;
                }

                Resep::create([
                    'id_rekam'     => $rekam->id,
                    'obat'         => trim($item['obat']),
                    'dosis'        => trim($item['dosis'] ?? ''),
                    'aturan_pakai' => trim($item['aturan_pakai'] ?? ''),
                ]);
            }
        }

        // Update status jadwal
        $jadwal->update(['status' => 'selesai']);

        return redirect()
            ->route('dokter.rekam.show', $rekam->id)
            ->with('success', 'Rekam medis berhasil dikonfirmasi dan disimpan!');
    }
}

