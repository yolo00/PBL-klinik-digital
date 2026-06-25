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
     * Skenario: Mengisi Rekam Medis — Simpan
     * - Validasi: keluhan dan diagnosa WAJIB diisi
     * - Jika diagnosa kosong → tampilkan validasi error
     * - Simpan data + resep ke database
     * - Update status jadwal menjadi selesai
     */
    public function storeRekamMedis(Request $request, $id)
    {
        // Saat ini, submission dari form edit-rekam-medis akan:
        // 1) Validasi
        // 2) Menampilkan halaman konfirmasi (draft dulu)
        // Konfirmasi & simpan final dilakukan di KonfirmasiRekamMedisController

        return app(\App\Http\Controllers\Dokter\KonfirmasiRekamMedisController::class)
            ->preview($request, $id);
    }
}
