<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Jadwal; 
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Alergi; 
use App\Models\JadwalSistem;
use App\Models\Pembayaran; // Penting: Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    // =======================================================
    // R: READ (Membaca Data Dashboard)
    // =======================================================
    public function index()
    {
        $user = Auth::user();
        $profilPasien = $user->pasien; 
        
        // Inisialisasi variabel agar tidak error di view jika kosong
        $totalKunjungan = 0;
        $terakhirKunjungan = null;
        $nextAppointment = null;
        $pendingPayment = null;

        // Jadwal operasional klinik
        $jadwalOperasional = JadwalSistem::harian()->get();

        // Urutan hari
        $urutanHari = JadwalSistem::urutanHari();

        // Sort sesuai urutan Senin-Minggu
        $jadwalOperasional = $jadwalOperasional->sortBy(function ($item) use ($urutanHari) {
            return $urutanHari[$item->hari] ?? 999;
        });

        // Kelompokkan berdasarkan jam yang sama
        $grupJadwal = [];

        foreach ($jadwalOperasional as $jadwal) {
            $key = implode('|', [
                $jadwal->is_libur,
                $jadwal->jam_buka,
                $jadwal->jam_tutup,
                $jadwal->jam_istirahat_mulai,
                $jadwal->jam_istirahat_selesai,
            ]);

            $grupJadwal[$key]['hari'][] = $jadwal->hari;
            $grupJadwal[$key]['data'] = $jadwal;
        }

        // Format hari menjadi Senin-Rabu dll
        $jadwalKlinik = [];

        foreach ($grupJadwal as $grup) {
            $hari = $grup['hari'];

            $labelHari = count($hari) > 1
                ? $hari[0] . ' - ' . end($hari)
                : $hari[0];

            $jadwalKlinik[] = [
                'hari' => $labelHari,
                'data' => $grup['data']
            ];
        }

        if ($profilPasien) {
            // Base query untuk jadwal pasien
            $query = Jadwal::where('id_pasien', $profilPasien->id);

            // 1. Statistik Kunjungan
            $totalKunjungan = (clone $query)->where('status', 'selesai')->count();
            $terakhirKunjungan = (clone $query)->where('status', 'selesai')->latest('tanggal')->first();

            // 2. Janji Berikutnya (Sudah diperbaiki dengan eager loading)
            $nextAppointment = (clone $query)
                ->with('dokter.user') // <-- TAMBAHKAN BARIS INI
                ->where('status', 'menunggu')
                ->where('tanggal', '>=', Carbon::today())
                ->orderBy('tanggal', 'asc')
                ->orderBy('jam', 'asc')
                ->first();

            // 3. Cek Pembayaran Pending (Mengambil 1 data terdekat dengan tanggal janji temu)
           $jadwalIds = (clone $query)->pluck('id');
$pendingPayment = Pembayaran::with('jadwal')
    ->whereIn('pembayaran.id_jadwal', $jadwalIds) // Tambahkan 'pembayaran.' di depan
    ->where('pembayaran.status', 'pending')      // Tambahkan 'pembayaran.' di depan
    ->join('jadwal', 'pembayaran.id_jadwal', '=', 'jadwal.id')
    ->where('jadwal.tanggal', '>=', Carbon::today()) 
    ->orderBy('jadwal.tanggal', 'asc')              
    ->orderBy('jadwal.jam', 'asc')                  
    ->select('pembayaran.*')                        
    ->first();// Hanya ambil 1 data terdekat
        }

        return view('pasien.dashboard', compact(
            'user', 
            'profilPasien', 
            'totalKunjungan', 
            'terakhirKunjungan', 
            'nextAppointment', 
            'pendingPayment',
            'jadwalKlinik'
        ));
    }

    // =======================================================
    // R: READ (Membaca Riwayat Jadwal Urut Terbaru)
    // =======================================================
    public function riwayatJadwal()
    {
        $profilPasien = Auth::user()->pasien;

        // Pastikan profil pasien ada sebelum query
        if (!$profilPasien) {
            return view('pasien.riwayat-jadwal', ['riwayatJadwal' => collect([])]);
        }

        // Mengambil data jadwal dengan urutan tanggal dan jam terbaru
        $riwayatJadwal = Jadwal::with(['dokter', 'pembayaran'])
            ->where('id_pasien', $profilPasien->id)
            ->orderBy('tanggal', 'asc') // Urutan dari tanggal paling baru
            ->orderBy('jam', 'asc')     // Jika tanggal sama, urutkan dari jam paling akhir
            ->get();

        return view('pasien.riwayat-jadwal', compact('riwayatJadwal'));
    }

    // =======================================================
    // TAMPIL FORM (Menyediakan data dokter & spesialisasi)
    // =======================================================
    public function buatJanji()
    {
        $dokters = Dokter::with('user')->get();
        // Ambil semua data spesialisasi untuk filter dropdown
        $spesialisasis = \App\Models\Spesialisasi::all(); 
        
        return view('pasien.buat-janji', compact('dokters', 'spesialisasis'));
    }

    // =======================================================
    // API UNTUK FILTER DINAMIS
    // =======================================================
    public function getDokterBySpesialisasi($id_spesialisasi)
    {
        // Jika memilih 'all', tampilkan semua dokter. Jika tidak, filter berdasarkan id_spesialisasi
        if ($id_spesialisasi === 'all') {
            $dokters = Dokter::with('user')->get();
        } else {
            $dokters = Dokter::with('user')->where('id_spesialisasi', $id_spesialisasi)->get();
        }

        // Format data menjadi JSON ringan agar cepat di-load oleh JavaScript
        $data = $dokters->map(function ($dokter) {
            return [
                'id' => $dokter->id,
                'nama' => $dokter->user->nama ?? ($dokter->user->name ?? 'Dokter Tanpa Nama')
            ];
        });

        return response()->json($data);
    }

    // =======================================================
    // EDIT & UPDATE PROFIL
    // =======================================================
    public function editProfil()
    {
        $user = auth()->user();
        $pasien = Pasien::where('id_user', $user->id)->first();
        
        return view('pasien.edit-profil', compact('user', 'pasien'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user(); 

        $request->validate([
            'nama'             => 'required|string|max:100',
            'no_hp'            => 'nullable|string|max:15',
            'jenis_kelamin'    => 'nullable|in:L,P',
            'tgl_lahir'        => 'nullable|date',
            'gol_darah'        => 'nullable|in:A,B,AB,O',
            'riwayat_penyakit' => 'nullable|string',
            'alergi'           => 'nullable|string'
        ]);

        $user->update([
            'nama'          => $request->nama,
            'no_hp'         => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir'     => $request->tgl_lahir,
        ]);

        $pasien = Pasien::updateOrCreate(
            ['id_user' => $user->id], 
            [
                'gol_darah'        => $request->gol_darah,
                'riwayat_penyakit' => $request->riwayat_penyakit,
            ]
        );

        Alergi::where('id_pasien', $pasien->id)->delete();

        if ($request->filled('alergi')) {
            $daftarAlergi = explode(',', $request->alergi);
            foreach ($daftarAlergi as $item) {
                $nama = trim($item); 
                if (!empty($nama)) {
                    Alergi::create([
                        'id_pasien'   => $pasien->id,
                        'nama_alergi' => $nama
                    ]);
                }
            }
        }

        return redirect()->route('pasien.profil')->with('success', 'Profil dan daftar alergi berhasil diperbarui!');
    }

    public function showProfil()
    {
        $user = auth()->user();
        $pasien = Pasien::where('id_user', $user->id)->first();
    
        return view('pasien.profil', compact('user', 'pasien'));
    }

    // =======================================================
    // C: CREATE (Membuat Data dengan Validasi Tanggal & Jam)
    // =======================================================
    public function storeJadwal(Request $request)
    {
        // 1. Validasi dasar dengan menambahkan array pesan kustom Bahasa Indonesia di parameter kedua
        $request->validate([
            'id_dokter' => 'required|exists:dokter,id',
            'tanggal'   => 'required|date|after_or_equal:today',
            'jam'       => 'required|integer',
        ], [
            // Pesan error kustom bahasa indonesia
            'id_dokter.required'     => 'Silakan pilih dokter terlebih dahulu.',
            'id_dokter.exists'       => 'Dokter yang dipilih tidak terdaftar.',
            'tanggal.required'       => 'Tanggal kunjungan wajib diisi.',
            'tanggal.date'           => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal kunjungan tidak boleh hari yang sudah lewat.',
            'jam.required'           => 'Waktu jam kunjungan wajib diisi.',
            'jam.integer'            => 'Format jam tidak valid.',
        ]);

        // 2. VALIDASI TAMBAHAN: Cek jika pendaftaran dilakukan hari ini, jamnya tidak boleh sudah lewat
        $tanggalInput = Carbon::parse($request->tanggal);
        
        if ($tanggalInput->isToday()) {
            // Mengambil jam saat ini di Zona Waktu Barat (WIB / Asia/Jakarta)
            $jamSekarang = Carbon::now('Asia/Jakarta')->hour; 
            
            // Jika jam yang dipilih pasien kurang dari atau sama dengan jam saat ini, tolak!
            if ((int)$request->jam <= $jamSekarang) {
                return redirect()->back()
                    ->withInput() 
                    ->withErrors([
                        'jam' => 'Waktu pendaftaran sudah lewat untuk hari ini. Silakan pilih jam atau tanggal yang akan datang.'
                    ]);
            }
        }

        $profilPasien = Auth::user()->pasien;

        if (!$profilPasien) {
            return redirect()->back()->with('error', 'Profil pasien tidak ditemukan.');
        }

        // Gunakan DB Transaction agar data sinkron
        DB::transaction(function () use ($request, $profilPasien) {
            // 1. Buat Jadwal
            $jadwal = Jadwal::create([
                'id_pasien' => $profilPasien->id,
                'id_dokter' => $request->id_dokter,
                'tanggal'   => $request->tanggal,
                'jam'       => $request->jam,
                'status'    => 'menunggu', 
            ]);

            // 2. Buat Pembayaran 
            Pembayaran::create([
                'id_jadwal' => $jadwal->id,
                'jumlah'    => 75000,
                'metode'    => 'cash', 
                'status'    => 'pending', 
            ]);
        });

        return redirect()->route('pasien.riwayat')->with('success', 'Jadwal berhasil dibuat!');
    }

    // =======================================================
    // TAMPIL DETAIL PEMBAYARAN
    // =======================================================
    public function detailPembayaran($id)
    {
        // 1. Cari data pembayaran berdasarkan ID beserta relasi jadwalnya
        $pembayaran = Pembayaran::with('jadwal.dokter')->findOrFail($id);
        
        // 2. Keamanan: Pastikan hanya pasien pemilik jadwal yang bisa melihat
        $profilPasien = Auth::user()->pasien;
        if (!$profilPasien || $pembayaran->jadwal->id_pasien != $profilPasien->id) {
            return redirect()->route('pasien.dashboard')->with('error', 'Akses ditolak! Ini bukan tagihan Anda.');
        }

        // 3. Tampilkan ke view
        return view('pasien.detail-pembayaran', compact('pembayaran'));
    }

// =======================================================
    // D: DELETE (Menghapus / Membatalkan Data Jadwal)
    // =======================================================
    public function destroyJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $profilPasien = Auth::user()->pasien;

        if ($profilPasien && $jadwal->id_pasien == $profilPasien->id) {
            
            // 1. Hapus data pembayaran yang terikat dengan jadwal ini terlebih dahulu
            Pembayaran::where('id_jadwal', $jadwal->id)->delete();

            // 2. Setelah bersih, baru hapus data jadwalnya
            $jadwal->delete(); 

            return redirect()->route('pasien.riwayat')->with('success', 'Jadwal temu berhasil dibatalkan.');
        }

        return redirect()->route('pasien.riwayat')->with('error', 'Akses ditolak!');
    }
}