<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Alergi;
use App\Models\JadwalSistem;
use App\Models\Pembayaran;
use App\Models\RekamMedis;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PasienController extends Controller
{
    // =======================================================
    // R: READ (Dashboard)
    // =======================================================
    public function index()
    {
        $user         = Auth::user();
        $profilPasien = $user->pasien;

        $totalKunjungan    = 0;
        $terakhirKunjungan = null;
        $nextAppointment   = null;
        $pendingPayment    = null;

        $jadwalOperasional = JadwalSistem::harian()->get();
        $urutanHari        = JadwalSistem::urutanHari();

        $jadwalOperasional = $jadwalOperasional->sortBy(function ($item) use ($urutanHari) {
            return $urutanHari[$item->hari] ?? 999;
        });

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
            $grupJadwal[$key]['data']   = $jadwal;
        }

        $jadwalKlinik = [];
        foreach ($grupJadwal as $grup) {
            $hari       = $grup['hari'];
            $labelHari  = count($hari) > 1 ? $hari[0] . ' - ' . end($hari) : $hari[0];
            $jadwalKlinik[] = ['hari' => $labelHari, 'data' => $grup['data']];
        }

        if ($profilPasien) {
            $query = Jadwal::where('id_pasien', $profilPasien->id);

            $totalKunjungan    = (clone $query)->where('status', 'selesai')->count();
            $terakhirKunjungan = (clone $query)->where('status', 'selesai')->latest('tanggal')->first();

            $nextAppointment = (clone $query)
                ->with('dokter.user')
                ->where('status', 'menunggu')
                ->where('tanggal', '>=', Carbon::today())
                ->orderBy('tanggal', 'asc')
                ->orderBy('jam', 'asc')
                ->first();
            // 3. Cek Pembayaran Pending (Mengambil 1 data terdekat dengan tanggal janji temu)
            $jadwalIds = (clone $query)->pluck('id');
            $pendingPayment = Pembayaran::with('jadwal')
                ->whereIn('pembayaran.id_jadwal', $jadwalIds)
                ->where('pembayaran.status', 'pending')
                ->join('jadwal', 'pembayaran.id_jadwal', '=', 'jadwal.id')
                ->where('jadwal.tanggal', '>=', Carbon::today())
                ->orderBy('jadwal.tanggal', 'asc')
                ->orderBy('jadwal.jam', 'asc')
                ->select('pembayaran.*')
                ->first();
        }

        return view('pasien.dashboard', compact(
            'user', 'profilPasien', 'totalKunjungan', 'terakhirKunjungan',
            'nextAppointment', 'pendingPayment', 'jadwalKlinik'
        ));
    }

    // =======================================================
    // R: READ (Riwayat Jadwal)
    // =======================================================
    public function riwayatJadwal()
    {
        $profilPasien = Auth::user()->pasien;

        if (!$profilPasien) {
            return view('pasien.riwayat-jadwal', ['riwayatJadwal' => collect([])]);
        }

        $riwayatJadwal = Jadwal::with(['dokter.user', 'dokter.spesialisasi', 'pembayaran'])
            ->where('id_pasien', $profilPasien->id)
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->get();

        return view('pasien.riwayat-jadwal', compact('riwayatJadwal'));
    }

    // =======================================================
    // TAMPIL FORM Buat Janji
    // =======================================================
    public function buatJanji()
    {
        $dokters       = Dokter::with(['user', 'spesialisasi'])->get();
        $spesialisasis = \App\Models\Spesialisasi::all();

        return view('pasien.buat-janji', compact('dokters', 'spesialisasis'));
    }

    // =======================================================
    // API — filter dokter by spesialisasi (JSON)
    // =======================================================
    public function getDokterBySpesialisasi($id_spesialisasi)
    {
        if ($id_spesialisasi === 'all') {
            $dokters = Dokter::with(['user', 'spesialisasi', 'jadwalDokters'])->get();
        } else {
            $dokters = Dokter::with(['user', 'spesialisasi', 'jadwalDokters'])
                ->where('id_spesialisasi', $id_spesialisasi)
                ->get();
        }

        $data = $dokters->map(function($d) {
            $hariAktif = $d->jadwalDokters->where('is_aktif', 1)->pluck('hari')->toArray();
            $hariAktifStr = !empty($hariAktif) ? implode(', ', $hariAktif) : 'Tidak ada jadwal aktif';

            return [
                'id'            => $d->id,
                'nama'          => $d->user->nama ?? ($d->user->name ?? 'Dokter Tanpa Nama'),
                'base_price'    => $d->spesialisasi->base_price ?? 75000,
                'spesialisasi'  => $d->spesialisasi->nama ?? 'Spesialis Umum',
                'foto_profil'   => $d->user->foto_profil ? asset('storage/' . $d->user->foto_profil) : 'https://placehold.co/150x150/059669/ffffff?text=U',
                'no_hp'         => $d->user->no_hp ?? '-',
                'jenis_kelamin' => $d->user->jenis_kelamin == 'L' ? 'Laki-laki' : ($d->user->jenis_kelamin == 'P' ? 'Perempuan' : '-'),
                'hari_aktif'    => $hariAktifStr,
            ];
        });

        return response()->json($data);
    }

    // =======================================================
    // API — ambil harga berdasarkan dokter terpilih (JSON)
    // =======================================================
    public function getHargaDokter($id_dokter)
    {
        $dokter = Dokter::with('spesialisasi')->find($id_dokter);
        if (!$dokter) {
            return response()->json(['base_price' => 75000]);
        }
        $harga = $dokter->spesialisasi->base_price ?? 75000;
        // Jika harga 0 dari DB, pakai default 75000
        if ($harga <= 0) $harga = 75000;

        return response()->json(['base_price' => $harga]);
    }

    // =======================================================
    // API — ambil jam tersedia berdasarkan jadwal dokter (JSON)
    // =======================================================
    public function getJamDokter(Request $request)
    {
        $id_dokter = $request->id_dokter;
        $tanggal   = $request->tanggal;

        if (!$id_dokter || !$tanggal) {
            return response()->json(['status' => 'empty', 'data' => []]);
        }

        // 1. Konversi tanggal pilihan menjadi nama hari Bahasa Indonesia
        $dayEnglish = Carbon::parse($tanggal)->format('l');
        $daftarHari = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu'
        ];
        $hariIndo = $daftarHari[$dayEnglish] ?? '';

        // 2. Ambil jadwal dokter yang aktif di hari tersebut
        $jadwal = JadwalDokter::where('id_dokter', $id_dokter)
                            ->where('hari', $hariIndo)
                            ->where('is_aktif', true)
                            ->first();

        if (!$jadwal) {
            return response()->json(['status' => 'not_available', 'data' => []]);
        }

        // Validasi jadwal sistem klinik
        $jadwalSistemKhusus  = JadwalSistem::where('tgl_khusus', $tanggal)->first();
        $jadwalSistemReguler = JadwalSistem::where('hari', $hariIndo)->first();
        $jadwalKlinik        = $jadwalSistemKhusus ?? $jadwalSistemReguler;

        if ($jadwalKlinik && $jadwalKlinik->is_libur) {
            return response()->json(['status' => 'not_available', 'data' => []]);
        }

        // ── NEWs: Ambil jam yang sudah terisi untuk dokter + tanggal ini ──
        // Status 'dibatalkan' tidak dihitung sebagai terisi
        $jamTerisi = Jadwal::where('id_dokter', $id_dokter)
            ->where('tanggal', $tanggal)
            ->whereNotIn('status', ['dibatalkan'])
            ->pluck('jam')
            ->toArray();
        // ──────────────────────────────────────────────────────────────────

        // 3. Generate slot jam berdasarkan jam_mulai sampai jam_selesai
        $listJam = [];
        for ($jam = $jadwal->jam_mulai; $jam < $jadwal->jam_selesai; $jam++) {

            // Lewati jam istirahat dokter
            if ($jadwal->override_istirahat_mulai && $jadwal->override_istirahat_selesai) {
                if ($jam >= $jadwal->override_istirahat_mulai && $jam < $jadwal->override_istirahat_selesai) {
                    continue;
                }
            }

            // Lewati jam di luar operasional atau jam istirahat klinik
            if ($jadwalKlinik) {
                if ($jadwalKlinik->jam_buka && $jam < $jadwalKlinik->jam_buka) continue;
                if ($jadwalKlinik->jam_tutup && $jam >= $jadwalKlinik->jam_tutup) continue;

                if ($jadwalKlinik->jam_istirahat_mulai && $jadwalKlinik->jam_istirahat_selesai) {
                    if ($jam >= $jadwalKlinik->jam_istirahat_mulai && $jam < $jadwalKlinik->jam_istirahat_selesai) {
                        continue;
                    }
                }
            }

            // ── NEW: Tandai slot yang sudah terisi ──
            $sudahTerisi = in_array($jam, $jamTerisi);

            $listJam[] = [
                'value'        => $jam,
                'label'        => sprintf('%02d:00 WIB', $jam),
                'sudah_terisi' => $sudahTerisi,   // true = sudah ada janji di jam ini
            ];
            // ────────────────────────────────────────
        }

        // ── NEW: Cek apakah semua slot sudah terisi ──
        $semuaTerisi = !empty($listJam) && collect($listJam)->every(fn($s) => $s['sudah_terisi']);
        if ($semuaTerisi) {
            return response()->json(['status' => 'full', 'data' => [], 'message' => 'Jadwal hari ini sudah penuh']);
        }
        // ─────────────────────────────────────────────

        return response()->json(['status' => 'success', 'data' => $listJam]);
    }

    // =======================================================
    // API — ambil jadwal tersedia flatpickr (disabled dates & allowed days) (JSON)
    // =======================================================
    public function getJadwalTersedia($id_dokter)
    {
        // 1. Ambil hari aktif dokter (0-6 di Javascript, 0=Minggu, 1=Senin, dst)
        $hariAktifMap = [
            'Minggu' => 0,
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6
        ];
        
        $jadwalDokter = JadwalDokter::where('id_dokter', $id_dokter)
            ->where('is_aktif', 1)
            ->pluck('hari')
            ->toArray();
            
        $allowedDays = array_map(function($h) use ($hariAktifMap) {
            return $hariAktifMap[$h] ?? -1;
        }, $jadwalDokter);

        // 2. Ambil tanggal cuti dokter (status disetujui)
        $cutiDokter = \App\Models\CutiDokter::where('id_dokter', $id_dokter)
            ->where('status', 'disetujui')
            ->where('sampai_tanggal', '>=', date('Y-m-d')) // Ambil cuti dari hari ini ke depan
            ->get();
            
        $disabledDates = [];
        
        foreach ($cutiDokter as $cuti) {
            $start = Carbon::parse($cuti->dari_tanggal);
            $end = Carbon::parse($cuti->sampai_tanggal);
            while ($start->lte($end)) {
                $disabledDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        // 3. Ambil tanggal libur klinik dari jadwal_sistem (khusus atau hari biasa)
        // Libur khusus (berdasarkan tgl_khusus)
        $liburKhusus = JadwalSistem::where('is_libur', 1)
            ->whereNotNull('tgl_khusus')
            ->where('tgl_khusus', '>=', date('Y-m-d'))
            ->pluck('tgl_khusus')
            ->toArray();
            
        foreach ($liburKhusus as $tgl) {
            $disabledDates[] = Carbon::parse($tgl)->format('Y-m-d');
        }

        // Libur mingguan (contoh Minggu selalu libur, tapi ini akan dihandle dengan allowedDays jika dokter tidak aktif di hari Minggu)
        // Kita bisa ambil is_libur untuk hari biasa
        $liburReguler = JadwalSistem::where('is_libur', 1)
            ->whereNull('tgl_khusus')
            ->pluck('hari')
            ->toArray();
            
        $disabledDays = array_map(function($h) use ($hariAktifMap) {
            return $hariAktifMap[$h] ?? -1;
        }, $liburReguler);

        // Hapus duplikat disabled dates
        $disabledDates = array_values(array_unique($disabledDates));

        return response()->json([
            'allowedDays' => $allowedDays,
            'disabledDates' => $disabledDates,
            'disabledDays' => $disabledDays // Jika klinik ada hari libur reguler, hari itu tak bisa dipilih
        ]);
    }

    // =======================================================
    // R: READ (Riwayat Rekam Medis)
    // =======================================================
    public function riwayatRekamMedis()
    {
        $profilPasien = Auth::user()->pasien;

        if (!$profilPasien) {
            $rekamMedis = collect();
        } else {
            // Kita gunakan whereHas untuk memastikan rekam medis tersebut memiliki jadwal yang valid
            $rekamMedis = RekamMedis::with(['jadwal.dokter.user', 'jadwal.dokter.spesialisasi'])
                ->whereHas('jadwal', function($query) use ($profilPasien) {
                    $query->where('id_pasien', $profilPasien->id);
                })
                ->get()
                ->sortByDesc(function ($item) {
                    // Mengakses tanggal dari relasi jadwal dengan aman
                    return $item->jadwal ? $item->jadwal->tanggal : '0000-00-00';
                });
        }

        return view('pasien.riwayat-rekam-medis', compact('rekamMedis'));
    }

    public function detailRekamMedis($id)
    {
        $profilPasien = Auth::user()->pasien;

        // Tambahkan 'resep' di dalam array with()
        $rekamMedis = RekamMedis::with(['jadwal.dokter.user', 'jadwal.dokter.spesialisasi', 'resep']) // Pastikan 'resep' di sini
        ->whereHas('jadwal', function($query) use ($profilPasien) {
            $query->where('id_pasien', $profilPasien->id);
        })
        ->findOrFail($id);

        return view('pasien.lihat', compact('rekamMedis'));
    }

    // =======================================================
    // EDIT & UPDATE Profil
    // =======================================================
    public function editProfil()
    {
        $user   = auth()->user();
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
            'alergi'           => 'nullable|string',
        ]);

        $user->update([
            'nama'          => $request->nama,
            'no_hp'         => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir'     => $request->tgl_lahir,
        ]);

        $pasien = Pasien::updateOrCreate(
            ['id_user' => $user->id],
            ['gol_darah' => $request->gol_darah, 'riwayat_penyakit' => $request->riwayat_penyakit]
        );

        Alergi::where('id_pasien', $pasien->id)->delete();
        if ($request->filled('alergi')) {
            foreach (explode(',', $request->alergi) as $item) {
                $nama = trim($item);
                if (!empty($nama)) {
                    Alergi::create(['id_pasien' => $pasien->id, 'nama_alergi' => $nama]);
                }
            }
        }

        return redirect()->route('pasien.profil')
            ->with('success', 'Profil dan daftar alergi berhasil diperbarui!');
    }

    public function showProfil()
    {
        $user   = auth()->user();
        $pasien = Pasien::where('id_user', $user->id)->first();
        return view('pasien.profil', compact('user', 'pasien'));
    }

    // =======================================================
    // C: CREATE Jadwal — dengan pilihan metode pembayaran
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

            'metode'    => 'required|in:cash,qris',
        ]);

        // Cek jam hari ini tidak lewat
        $tanggalInput = Carbon::parse($request->tanggal);
        if ($tanggalInput->isToday()) {
            $jamSekarang = Carbon::now('Asia/Jakarta')->hour;
            if ((int) $request->jam <= $jamSekarang) {
                return redirect()->back()->withInput()->withErrors([
                    'jam' => 'Waktu pendaftaran sudah lewat untuk hari ini. Pilih jam atau tanggal yang akan datang.',
                ]);
            }
        }

        $profilPasien = Auth::user()->pasien;
        if (!$profilPasien) {
            return redirect()->back()->with('error', 'Profil pasien tidak ditemukan.');
        }

        // Ambil harga dari spesialisasi dokter
        $dokter = Dokter::with('spesialisasi')->find($request->id_dokter);
        $harga  = ($dokter && $dokter->spesialisasi && $dokter->spesialisasi->base_price > 0)
            ? $dokter->spesialisasi->base_price
            : 75000;

        $jadwal = null;
        DB::transaction(function () use ($request, $profilPasien, $harga, &$jadwal) {
            $jadwal = Jadwal::create([
                'id_pasien' => $profilPasien->id,
                'id_dokter' => $request->id_dokter,
                'tanggal'   => $request->tanggal,
                'jam'       => $request->jam,
                'status'    => 'menunggu',
            ]);

            Pembayaran::create([
                'id_jadwal' => $jadwal->id,
                'jumlah'    => $harga,
                'metode'    => $request->metode,
                'status'    => 'pending',
            ]);
        });

        // Jika memilih QRIS → langsung ke riwayat dengan pesan qris
        if ($request->metode === 'qris' && $jadwal) {
            return redirect()->route('pasien.riwayat')
                ->with('success', 'Jadwal berhasil dibuat! Silakan selesaikan pembayaran QRIS di menu riwayat jadwal.');
        }

        return redirect()->route('pasien.riwayat')
            ->with('success', 'Jadwal berhasil dibuat! Silakan lakukan pembayaran di klinik.');
    }
    
    // =======================================================
    // CREATE PDF Rekam Medis
    // =======================================================
    public function exportPdf($id)
    {
        $profilPasien = Auth::user()->pasien;

        // Mengambil data rekam medis yang dimiliki oleh pasien yang sedang login
        $rekamMedis = RekamMedis::with(['jadwal.dokter.user', 'jadwal.dokter.spesialisasi', 'resep'])
            ->whereHas('jadwal', function($query) use ($profilPasien) {
                $query->where('id_pasien', $profilPasien->id);
            })
            ->findOrFail($id);

        // Mengubah data menjadi PDF menggunakan view 'pasien.pdf-rekam-medis'
        $pdf = Pdf::loadView('pasien.pdf-rekam-medis', compact('rekamMedis'));
        
        // Memberikan nama file download
        return $pdf->download('Rekam-Medis-'.$rekamMedis->id.'.pdf');
    }

    // =======================================================
    // D: DELETE (Batal Jadwal)
    // =======================================================
    public function destroyJadwal($id)
    {
        $jadwal       = Jadwal::findOrFail($id);
        $profilPasien = Auth::user()->pasien;

        if ($profilPasien && $jadwal->id_pasien == $profilPasien->id) {
            Pembayaran::where('id_jadwal', $jadwal->id)->delete();
            $jadwal->delete();
            return redirect()->route('pasien.riwayat')
                ->with('success', 'Jadwal temu berhasil dibatalkan.');
        }

        return redirect()->route('pasien.riwayat')->with('error', 'Akses ditolak!');
    }
}