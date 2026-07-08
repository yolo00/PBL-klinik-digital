<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\RekamMedis;
use App\Models\Resep;
use App\Models\Notifikasi;
use App\Models\AkunUser;
use Illuminate\Http\Request;

class KonfirmasiRekamMedisController extends Controller
{
    /**
     * Menampilkan Halaman Preview menggunakan request GET
     */
    public function preview(Request $request, $jadwalId)
    {
        // Load jadwal beserta rekam medis dan resep yang barusan disimpan sebagai draft
        $jadwal = Jadwal::with(['pasien.user', 'pasien.alergi', 'dokter.user', 'rekamMedis.resep'])->findOrFail($jadwalId);
        $dokterId = auth()->user()->dokter->id;

        if ((int) $jadwal->id_dokter !== (int) $dokterId) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }

        // Jika sudah final, jangan izinkan konfirmasi lagi.
        if ($jadwal->rekamMedis && (bool) $jadwal->rekamMedis->is_final) {
            abort(403, 'Rekam medis sudah dikonfirmasi dan tidak dapat diubah.');
        }

        // Validasi window akses (dipertahankan dari kode aslimu)
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

        // Ambil data dari database draft
        $rekamMedis = $jadwal->rekamMedis;
        
        // Jika rekam medis draft entah bagaimana tidak ditemukan, kembalikan ke form pembuatan
        if (!$rekamMedis) {
            return redirect()->route('dokter.jadwal.buat-rekam', $jadwalId);
        }

        return view('dokter.konfirmasi-rekam-medis', [
            'jadwal'   => $jadwal,
            'keluhan'  => $rekamMedis->keluhan,
            'diagnosa' => $rekamMedis->diagnosa,
            'catatan'  => $rekamMedis->catatan,
            'resep'    => $rekamMedis->resep->toArray(), // Mengambil data resep dari database
        ]);
    }

    /**
     * Mengubah status rekam medis dari draft menjadi FINAL
     */
    public function konfirmasi(Request $request, $jadwalId)
    {
        $jadwal = Jadwal::with(['rekamMedis', 'pasien.user', 'dokter.user', 'pembayaran'])->findOrFail($jadwalId);
        $dokterId = auth()->user()->dokter->id;

        if ((int) $jadwal->id_dokter !== (int) $dokterId) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }

        if (!$jadwal->rekamMedis) {
            abort(404, 'Data rekam medis tidak ditemukan.');
        }

        if ((bool) $jadwal->rekamMedis->is_final) {
            abort(403, 'Rekam medis sudah dikonfirmasi dan tidak dapat diubah.');
        }

        // Karena data teks dan resep sudah masuk di database saat step store, 
        // di sini kita hanya perlu mengubah flag is_final menjadi true dan menyelesaikan jadwal.
        $jadwal->rekamMedis->update([
            'is_final'   => true,
            'updated_by' => auth()->id(),
        ]);

        // Update status jadwal menjadi selesai
        $jadwal->update(['status' => 'selesai']);

        // ── NOTIFIKASI: beritahu pasien bahwa rekam medis telah dibuat ──
        if ($jadwal->pasien && $jadwal->pasien->user) {
            $namaDokter = auth()->user()->nama ?? 'Dokter';
            $tglStr     = \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y');

            Notifikasi::kirim([
                'type'       => 'Rekam Medis Baru',
                'message'    => "Dr. {$namaDokter} telah membuat rekam medis untuk kunjungan Anda pada {$tglStr}.",
                'ref_tabel'  => 'rekam_medis',
                'ref_id'     => $jadwal->rekamMedis->id,
                'is_urgent'  => 0,
                'created_by' => auth()->id(),
            ], $jadwal->pasien->id_user);
        }

        // ── NOTIFIKASI: jika pembayaran cash + pending → beritahu semua admin ──
        if ($jadwal->pembayaran
            && $jadwal->pembayaran->metode === 'cash'
            && $jadwal->pembayaran->status === 'pending'
        ) {
            $adminIds   = AkunUser::where('role', 'A')->whereNull('deleted_at')->pluck('id')->toArray();
            $namaPasien = $jadwal->pasien->user->nama ?? 'Pasien';
            $namaDokter = $jadwal->dokter->user->nama ?? 'Dokter';

            if (!empty($adminIds)) {
                Notifikasi::kirim([
                    'type'       => 'Konfirmasi Pembayaran Cash',
                    'message'    => "Jadwal {$namaPasien} dengan Dr. {$namaDokter} telah selesai. Metode pembayaran: Cash. Mohon konfirmasi pembayaran.",
                    'ref_tabel'  => 'pembayaran',
                    'ref_id'     => $jadwal->pembayaran->id,
                    'is_urgent'  => 0,
                    'created_by' => auth()->id(),
                ], $adminIds);
            }
        }
        // ────────────────────────────────────────────────────────────────

        return redirect()
            ->route('dokter.rekam.show', $jadwal->rekamMedis->id)
            ->with('success', 'Rekam medis berhasil dikonfirmasi dan disimpan!');
    }
}