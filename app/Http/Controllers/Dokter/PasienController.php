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

        // Jika rekam medis sudah ada:
        if ($jadwal->rekamMedis) {
            // Jika sudah final (dikonfirmasi), langsung tampilkan detail
            if ((bool) $jadwal->rekamMedis->is_final) {
                return redirect()
                    ->route('dokter.rekam.show', $jadwal->rekamMedis->id)
                    ->with('info', 'Rekam medis sudah dikonfirmasi dan tidak dapat diedit.');
            }

            // Draft masih boleh diedit
            return view('dokter.edit-rekam-medis', compact('jadwal'));
        }

        // Cek window akses (hari ini, kemarin, atau sudah lewat)
        $today = now()->toDateString();
        $jadwalTanggal = $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->toDateString() : null;
        if ($jadwalTanggal === null) {
            abort(403, 'Rekam medis hanya bisa diisi pada jadwal dengan tanggal yang valid.');
        }

        $allowed = (
            $jadwalTanggal === $today ||
            $jadwalTanggal === \Carbon\Carbon::parse($today)->subDay()->toDateString() ||
            \Carbon\Carbon::parse($jadwalTanggal)->lt(\Carbon\Carbon::parse($today))
        );

        if (!$allowed) {
            abort(403, 'Rekam medis hanya bisa diisi pada hari ini, kemarin, atau jadwal yang sudah berlalu.');
        }

        return view('dokter.edit-rekam-medis', compact('jadwal'));
    }

    /**
     * Skenario: Mengisi Rekam Medis — Simpan Draft & Redirect ke Preview
     */
    public function storeRekamMedis(Request $request, $id)
    {
        // 1. Validasi input form rekam medis & resep
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

        $jadwal = Jadwal::findOrFail($id);

        // 2. Simpan atau Update sebagai DRAFT (is_final = 0)
        $rekam = RekamMedis::updateOrCreate(
            ['id_jadwal' => $jadwal->id],
            [
                'keluhan'    => $validated['keluhan'],
                'diagnosa'   => $validated['diagnosa'],
                'catatan'    => $validated['catatan'] ?? null,
                'is_final'   => false, // Masih berstatus draft/preview
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]
        );

        // Simpan resep sementara (draft)
        $rekam->resep()->delete();
        $resepInput = $validated['resep'] ?? [];
        if (is_array($resepInput)) {
            foreach ($resepInput as $item) {
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

        // 3. KUNCI SOLUSI: Redirect menggunakan GET ke route preview
        return redirect()->route('dokter.rekam-medis.konfirmasi-preview', ['id' => $jadwal->id]);
    }
}
