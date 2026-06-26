<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\RekamMedis;
use App\Models\Resep;
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
        $jadwal = Jadwal::with(['rekamMedis'])->findOrFail($jadwalId);
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

        return redirect()
            ->route('dokter.rekam.show', $jadwal->rekamMedis->id)
            ->with('success', 'Rekam medis berhasil dikonfirmasi dan disimpan!');
    }
}