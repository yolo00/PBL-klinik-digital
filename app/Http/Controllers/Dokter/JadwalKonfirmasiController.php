<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalKonfirmasiController extends Controller
{
    /**
     * Konfirmasi jadwal: hanya boleh jika tanggal jadwal adalah HARI INI
     * Mengubah status dari `menunggu` -> `konfirmasi`.
     */
    public function konfirmasi(Request $request, $jadwalId)
    {
        $jadwal = Jadwal::with(['pasien.user', 'dokter.user'])->findOrFail($jadwalId);
        $dokterId = auth()->user()->dokter->id;

        if ((int) $jadwal->id_dokter !== (int) $dokterId) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }

        if (empty($jadwal->tanggal)) {
            abort(403, 'Jadwal tidak memiliki tanggal yang valid.');
        }

        $jadwalTanggal = \Carbon\Carbon::parse($jadwal->tanggal)->startOfDay();
        $today = \Carbon\Carbon::today();

        if (!$jadwalTanggal->isSameDay($today)) {
            abort(403, 'Konfirmasi hanya bisa dilakukan pada hari ini.');
        }

        if ($jadwal->status !== 'menunggu') {
            abort(403, 'Jadwal tidak dalam status menunggu.');
        }

        $jadwal->update([
            'status' => 'konfirmasi',
        ]);

        // TODO: (opsional) tambahkan notifikasi/ audit log jika sistem Anda memilikinya

        return redirect()
            ->route('dokter.jadwal', ['filter' => 'semua'])
            ->with('success', 'Jadwal berhasil dikonfirmasi!');
    }
}

