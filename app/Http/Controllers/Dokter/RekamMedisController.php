<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    // 1. READ: Tampilkan List Rekam Medis Utama
    public function index()
    {
        $rekam_medis = DB::table('rekam_medis')
            ->join('jadwal', 'rekam_medis.id_jadwal', '=', 'jadwal.id')
            ->join('pasien', 'jadwal.id_pasien', '=', 'pasien.id')
            ->join('dokter', 'jadwal.id_dokter', '=', 'dokter.id')
            ->join('akun_user as user_pasien', 'pasien.id_user', '=', 'user_pasien.id')
            ->join('akun_user as user_dokter', 'dokter.id_user', '=', 'user_dokter.id')
            ->select(
                'rekam_medis.*',
                'user_pasien.nama as nama_pasien',
                'user_dokter.nama as nama_dokter',
                'rekam_medis.created_at as tanggal_periksa'
            )
            ->orderBy('rekam_medis.id', 'desc')
            ->get();

        return view('dokter.rekam-medis-dokter', compact('rekam_medis'));
    }

    // 2. EDIT / CREATE FORM (Menampilkan Identitas Berdasarkan ID Jadwal)
    public function edit($id)
    {
        // Cari data rekam medis berdasarkan id_jadwal (Sesuai Struktur phpMyAdmin)
        $rekam_medis = DB::table('rekam_medis')->where('id_jadwal', $id)->first();

        // Tarik data informasi pasien dan dokter
        $jadwal_info = DB::table('jadwal')
            ->join('pasien', 'jadwal.id_pasien', '=', 'pasien.id')
            ->join('dokter', 'jadwal.id_dokter', '=', 'dokter.id')
            ->join('akun_user as u_pasien', 'pasien.id_user', '=', 'u_pasien.id')
            ->join('akun_user as u_dokter', 'dokter.id_user', '=', 'u_dokter.id')
            ->select(
                'jadwal.id as id_jadwal',
                'u_pasien.nama as nama_pasien',
                'u_dokter.nama as nama_dokter'
            )
            ->where('jadwal.id', $id)
            ->first();

        // Jika data belum ada di DB, buat objek kosong agar tidak error di view
        if (!$rekam_medis) {
            $rekam_medis = (object) [
                'keluhan' => '',
                'diagnosa' => '',
                'catatan' => ''
            ];
            $is_edit = false;
        } else {
            $is_edit = true;
        }

        return view('dokter.edit-rekam-medis', compact('rekam_medis', 'jadwal_info', 'is_edit', 'id'));
    }

    // 3. UPDATE / INSERT DATA PROCESS
    public function update(Request $request, $id)
    {
        $request->validate([
            'keluhan'  => 'required',
            'diagnosa' => 'required',
            'catatan'  => 'required',
        ]);

        $exists = DB::table('rekam_medis')->where('id_jadwal', $id)->exists();

        $data = [
            'keluhan'    => trim($request->keluhan),
            'diagnosa'   => trim($request->diagnosa),
            'catatan'    => trim($request->catatan),
            'updated_at' => now(),
        ];

        if ($exists) {
            // Jalankan UPDATE jika data rekam medis sudah ada
            DB::table('rekam_medis')->where('id_jadwal', $id)->update($data);
            $pesan = 'Rekam medis pasien berhasil diperbarui!';
        } else {
            // Jalankan INSERT jika data rekam medis baru pertama dibuat
            $data['id_jadwal'] = $id;
            $data['created_at'] = now();
            DB::table('rekam_medis')->insert($data);
            $pesan = 'Rekam medis baru berhasil ditambahkan!';
        }

        return redirect()->route('dokter.rekam-medis')->with('success', $pesan);
    }

    // 4. DESTROY PROCESS
    public function destroy($id)
    {
        DB::table('rekam_medis')->where('id_jadwal', $id)->delete();
        return redirect()->route('dokter.rekam-medis')->with('success', 'Rekam Medis berhasil dihapus!');
    }
}