<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\RekamMedis;

class PasienController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with('pasien')->get();
        return view('dokter.jadwal-saya', compact('jadwals'));
    }

    public function buatRekam($id)
    {
        $jadwal = Jadwal::with('pasien')->findOrFail($id);
        return view('dokter.edit-rekam-medis', compact('jadwal'));
    }

    public function storeRekamMedis(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'keluhan' => 'required',
            'diagnosa' => 'required',
        ]);

        // Simpan ke database
        \App\Models\RekamMedis::create([
            'id_jadwal' => $id, // Tambahkan ini agar id_jadwal terisi
            'id_pasien' => $request->id_pasien, // Pastikan ini juga tersedia dari input atau $jadwal
            'keluhan'   => $request->keluhan,
            'diagnosa'  => $request->diagnosa,
            'tindakan'  => $request->tindakan,    // Pastikan field ini ada di tabel
            'resep_obat' => $request->resep_obat, // Pastikan field ini ada di tabel
        ]);

        // Update status jadwal agar berubah menjadi 'selesai'
        \App\Models\Jadwal::where('id', $id)->update(['status' => 'selesai']);

        return redirect()->route('dokter.jadwal')->with('success', 'Rekam medis berhasil disimpan!');
    }
}