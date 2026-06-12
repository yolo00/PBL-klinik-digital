<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\RekamMedis;

class PasienController extends Controller
{
    /**
     * Daftar semua pasien yang pernah/sedang berkonsultasi dengan dokter ini.
     * BUG FIX: gunakan $user->dokter->id, bukan $user->id
     */
    public function index()
    {
        $dokterId = auth()->user()->dokter->id;

        $pasiens = Pasien::whereHas('jadwals', function ($query) use ($dokterId) {
            $query->where('id_dokter', $dokterId);
        })->with('user')->get();

        return view('dokter.pasien-dokter', compact('pasiens'));
    }

    /**
     * Form isi rekam medis — dipanggil dari jadwal
     */
    public function buatRekam($id)
    {
        $jadwal = Jadwal::with(['pasien.user', 'pasien.alergi'])->findOrFail($id);

        // Pastikan jadwal ini milik dokter yang login
        $dokterId = auth()->user()->dokter->id;
        if ($jadwal->id_dokter !== $dokterId) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('dokter.edit-rekam-medis', compact('jadwal'));
    }

    /**
     * Simpan rekam medis baru
     */
    public function storeRekamMedis(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        // Pastikan jadwal ini milik dokter yang login
        $dokterId = auth()->user()->dokter->id;
        if ($jadwal->id_dokter !== $dokterId) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $request->validate([
            'keluhan'  => 'required|string',
            'diagnosa' => 'required|string',
        ]);

        RekamMedis::create([
            'id_jadwal'  => $jadwal->id,
            'keluhan'    => $request->keluhan,
            'diagnosa'   => $request->diagnosa,
            'tindakan'   => $request->tindakan,
            'catatan'    => $request->catatan,
            'created_by' => auth()->id(),
        ]);

        // Update status jadwal menjadi selesai
        $jadwal->update(['status' => 'selesai']);

        return redirect()->route('dokter.jadwal')->with('success', 'Rekam medis berhasil disimpan!');
    }
}