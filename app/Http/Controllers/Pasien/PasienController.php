<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Jadwal; 
use App\Models\Pasien;
use App\Models\Dokter; // Tambahkan import ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    // =======================================================
    // R: READ (Membaca Data)
    // =======================================================
    public function index()
    {
        $user = Auth::user();
        $profilPasien = $user->pasien; 
        
        $riwayatJadwal = $profilPasien ? Jadwal::where('id_pasien', $profilPasien->id)->orderBy('tanggal', 'desc')->get() : collect([]);

        return view('pasien.dashboard', compact('user', 'profilPasien', 'riwayatJadwal'));
    }

    // =======================================================
    // TAMPIL FORM (Menyediakan data dokter)
    // =======================================================
   public function buatJanji()
{
    // Mengambil data dokter dan menyertakan relasi ke akun_user
    $dokters = \App\Models\Dokter::with('user')->get();
    
    return view('pasien.buat-janji', compact('dokters'));
}
    // =======================================================
    // C: CREATE (Membuat Data)
    // =======================================================
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required|exists:dokter,id', // Validasi: ID dokter harus ada di tabel dokter
            'tanggal'   => 'required|date|after_or_equal:today', // Validasi: Tidak boleh tanggal lampau
            'jam'       => 'required|integer',
        ]);

        $profilPasien = Auth::user()->pasien;

        if (!$profilPasien) {
            return redirect()->back()->with('error', 'Profil pasien tidak ditemukan. Lengkapi profil Anda terlebih dahulu.');
        }

        Jadwal::create([
            'id_pasien' => $profilPasien->id,
            'id_dokter' => $request->id_dokter,
            'tanggal'   => $request->tanggal,
            'jam'       => $request->jam,
            'status'    => 'menunggu', 
        ]);

        return redirect()->route('pasien.riwayat')->with('success', 'Jadwal berhasil dibuat!');
    }

    // =======================================================
    // U: UPDATE (Mengubah Data)
    // =======================================================
    public function updateProfil(Request $request)
    {
        $request->validate([
            'gol_darah'        => 'nullable|string|max:3',
            'riwayat_penyakit' => 'nullable|string',
        ]);

        $profilPasien = Auth::user()->pasien;

        if ($profilPasien) {
            $profilPasien->update([
                'gol_darah'        => $request->gol_darah,
                'riwayat_penyakit' => $request->riwayat_penyakit,
            ]);
        }

        return redirect()->route('pasien.dashboard')->with('success', 'Profil medis berhasil diperbarui!');
    }

    // =======================================================
    // D: DELETE (Menghapus Data)
    // =======================================================
    public function destroyJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $profilPasien = Auth::user()->pasien;

        // Hanya pemilik jadwal yang bisa menghapus
        if ($profilPasien && $jadwal->id_pasien == $profilPasien->id) {
            $jadwal->delete(); 
            return redirect()->route('pasien.riwayat')->with('success', 'Jadwal temu berhasil dibatalkan.');
        }

        return redirect()->route('pasien.riwayat')->with('error', 'Akses ditolak!');
    }

    // Menampilkan halaman riwayat jadwal
    public function riwayatJadwal()
    {
        $profilPasien = Auth::user()->pasien;

        $riwayatJadwal = $profilPasien 
            ? Jadwal::where('id_pasien', $profilPasien->id)->orderBy('tanggal', 'desc')->get()
            : collect([]);

        return view('pasien.riwayat-jadwal', compact('riwayatJadwal'));
    }
}