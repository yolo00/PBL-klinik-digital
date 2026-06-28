<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Spesialisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminDokterController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokter::with(['user', 'spesialisasi'])
            ->join('akun_user', 'dokter.id_user', '=', 'akun_user.id')
            ->select('dokter.*');

        // Pencarian nama atau spesialisasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('akun_user.nama', 'like', "%{$search}%")
                  ->orWhereHas('spesialisasi', function ($sq) use ($search) {
                      $sq->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Sortir
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'nama_asc'  => $query->orderBy('akun_user.nama', 'asc'),
            'nama_desc' => $query->orderBy('akun_user.nama', 'desc'),
            default     => $query->orderByDesc('dokter.id'),
        };

        $dokters = $query->paginate(10)->withQueryString();

        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        $spesialisasis = Spesialisasi::all();
        return view('admin.dokter.create', compact('spesialisasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:100',
            'email'           => 'required|email|unique:akun_user,email',
            'password'        => 'required|string|min:6',
            'id_spesialisasi' => 'required|exists:spesialisasi,id',
            'no_hp'           => 'required|string|max:15',
            'jenis_kelamin'   => 'required|in:L,P',
            'tgl_lahir'       => 'required|date',
            'pendidikan'      => 'nullable|string|max:200',
            'dokumen_sip'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto_profil'     => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'tanda_tangan'    => 'nullable|file|mimes:png|max:2048',
        ], [
            'nama.required'            => 'Nama wajib diisi.',
            'email.required'           => 'Email wajib diisi.',
            'email.unique'             => 'Email sudah terdaftar.',
            'password.required'        => 'Password wajib diisi.',
            'password.min'             => 'Password minimal 6 karakter.',
            'id_spesialisasi.required' => 'Spesialisasi wajib dipilih.',
            'id_spesialisasi.exists'   => 'Spesialisasi tidak valid.',
            'no_hp.required'           => 'Nomor HP wajib diisi.',
            'jenis_kelamin.required'   => 'Jenis kelamin wajib dipilih.',
            'tgl_lahir.required'       => 'Tanggal lahir wajib diisi.',
            'dokumen_sip.mimes'        => 'Dokumen SIP harus berformat PDF, JPG, atau PNG.',
            'dokumen_sip.max'          => 'Ukuran dokumen SIP maksimal 2MB.',
            'foto_profil.mimes'        => 'Foto profil harus berformat JPG atau PNG.',
            'foto_profil.max'          => 'Ukuran foto profil maksimal 2MB.',
            'tanda_tangan.mimes'       => 'Tanda tangan harus berformat PNG.',
            'tanda_tangan.max'         => 'Ukuran tanda tangan maksimal 2MB.',
        ]);

        DB::transaction(function () use ($request) {
            $userId = DB::table('akun_user')->insertGetId([
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'nama'          => $request->nama,
                'no_hp'         => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tgl_lahir'     => $request->tgl_lahir,
                'role'          => 'D',
                'created_at'    => now(),
            ]);

            $dokterId = DB::table('dokter')->insertGetId([
                'id_user'         => $userId,
                'id_spesialisasi' => $request->id_spesialisasi,
                'pendidikan'      => $request->pendidikan,
            ]);

            // Upload dokumen SIP jika ada
            if ($request->hasFile('dokumen_sip')) {
                $file     = $request->file('dokumen_sip');
                $filename = 'sip_' . time() . '_' . $userId . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('sip'), $filename);
                DB::table('dokter')->where('id', $dokterId)->update(['dokumen_sip' => 'sip/' . $filename]);
            }

            // Upload foto profil jika ada
            if ($request->hasFile('foto_profil')) {
                $file     = $request->file('foto_profil');
                $filename = 'foto_' . time() . '_' . $userId . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('foto_profil'), $filename);
                DB::table('dokter')->where('id', $dokterId)->update(['foto_profil' => 'foto_profil/' . $filename]);
            }

            // Upload tanda tangan jika ada
            if ($request->hasFile('tanda_tangan')) {
                $file     = $request->file('tanda_tangan');
                $filename = 'ttd_' . time() . '_' . $userId . '.png';
                $file->move(public_path('tanda_tangan'), $filename);
                DB::table('dokter')->where('id', $dokterId)->update(['tanda_tangan' => 'tanda_tangan/' . $filename]);
            }

            // Generate Jadwal Dokter 6 hari (Senin - Sabtu)
            $jadwalSistems = \App\Models\JadwalSistem::harian()
                ->whereIn('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])
                ->get()
                ->keyBy('hari');

            $hariKerja = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            foreach ($hariKerja as $hari) {
                $js               = $jadwalSistems->get($hari);
                $isAktif          = 1;
                $jamMulai         = 0;
                $jamSelesai       = 0;
                $istirahatMulai   = null;
                $istirahatSelesai = null;

                if ($js && !$js->is_libur && $js->jam_buka !== null && $js->jam_tutup !== null) {
                    $jamMulai         = $js->jam_buka;
                    $jamSelesai       = $js->jam_tutup;
                    $istirahatMulai   = $js->jam_istirahat_mulai;
                    $istirahatSelesai = $js->jam_istirahat_selesai;
                } else {
                    $isAktif = 0;
                }

                DB::table('jadwal_dokter')->insert([
                    'id_dokter'                  => $dokterId,
                    'hari'                       => $hari,
                    'jam_mulai'                  => $jamMulai,
                    'jam_selesai'                => $jamSelesai,
                    'override_istirahat_mulai'   => $istirahatMulai,
                    'override_istirahat_selesai' => $istirahatSelesai,
                    'is_aktif'                   => $isAktif,
                ]);
            }
        });

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function show($id)
    {
        $dokter = Dokter::with(['user', 'spesialisasi', 'jadwals.pasien.user', 'cutiDokters', 'jadwalDokters'])
            ->findOrFail($id);

        return view('admin.dokter.detail', compact('dokter'));
    }

    public function edit($id)
    {
        $dokter        = Dokter::with(['user', 'spesialisasi'])->findOrFail($id);
        $spesialisasis = Spesialisasi::all();

        return view('admin.dokter.edit', compact('dokter', 'spesialisasis'));
    }

    public function update(Request $request, $id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:100',
            'email'           => 'required|email|unique:akun_user,email,' . $dokter->id_user,
            'password'        => 'nullable|string|min:6',
            'id_spesialisasi' => 'required|exists:spesialisasi,id',
            'no_hp'           => 'required|string|max:15',
            'jenis_kelamin'   => 'required|in:L,P',
            'tgl_lahir'       => 'required|date',
            'pendidikan'      => 'nullable|string|max:200',
            'dokumen_sip'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto_profil'     => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'tanda_tangan'    => 'nullable|file|mimes:png|max:2048',
        ], [
            'nama.required'            => 'Nama wajib diisi.',
            'email.required'           => 'Email wajib diisi.',
            'email.unique'             => 'Email sudah terdaftar.',
            'password.min'             => 'Password minimal 6 karakter.',
            'id_spesialisasi.required' => 'Spesialisasi wajib dipilih.',
            'id_spesialisasi.exists'   => 'Spesialisasi tidak valid.',
            'no_hp.required'           => 'Nomor HP wajib diisi.',
            'jenis_kelamin.required'   => 'Jenis kelamin wajib dipilih.',
            'tgl_lahir.required'       => 'Tanggal lahir wajib diisi.',
            'dokumen_sip.mimes'        => 'Dokumen SIP harus berformat PDF, JPG, atau PNG.',
            'dokumen_sip.max'          => 'Ukuran dokumen SIP maksimal 2MB.',
            'foto_profil.mimes'        => 'Foto profil harus berformat JPG atau PNG.',
            'foto_profil.max'          => 'Ukuran foto profil maksimal 2MB.',
            'tanda_tangan.mimes'       => 'Tanda tangan harus berformat PNG.',
            'tanda_tangan.max'         => 'Ukuran tanda tangan maksimal 2MB.',
        ]);

        DB::transaction(function () use ($request, $dokter) {
            $userData = [
                'email'         => $request->email,
                'nama'          => $request->nama,
                'no_hp'         => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tgl_lahir'     => $request->tgl_lahir,
                'updated_at'    => now(),
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            DB::table('akun_user')
                ->where('id', $dokter->id_user)
                ->update($userData);

            DB::table('dokter')
                ->where('id', $dokter->id)
                ->update([
                    'id_spesialisasi' => $request->id_spesialisasi,
                    'pendidikan'      => $request->pendidikan,
                ]);

            // Upload dokumen SIP baru jika ada
            if ($request->hasFile('dokumen_sip')) {
                if ($dokter->dokumen_sip && File::exists(public_path($dokter->dokumen_sip))) {
                    File::delete(public_path($dokter->dokumen_sip));
                }
                $file     = $request->file('dokumen_sip');
                $filename = 'sip_' . time() . '_' . $dokter->id_user . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('sip'), $filename);
                DB::table('dokter')->where('id', $dokter->id)->update(['dokumen_sip' => 'sip/' . $filename]);
            }

            // Upload foto profil baru jika ada
            if ($request->hasFile('foto_profil')) {
                if ($dokter->foto_profil && File::exists(public_path($dokter->foto_profil))) {
                    File::delete(public_path($dokter->foto_profil));
                }
                $file     = $request->file('foto_profil');
                $filename = 'foto_' . time() . '_' . $dokter->id_user . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('foto_profil'), $filename);
                DB::table('dokter')->where('id', $dokter->id)->update(['foto_profil' => 'foto_profil/' . $filename]);
            }

            // Upload tanda tangan baru jika ada
            if ($request->hasFile('tanda_tangan')) {
                if ($dokter->tanda_tangan && File::exists(public_path($dokter->tanda_tangan))) {
                    File::delete(public_path($dokter->tanda_tangan));
                }
                $file     = $request->file('tanda_tangan');
                $filename = 'ttd_' . time() . '_' . $dokter->id_user . '.png';
                $file->move(public_path('tanda_tangan'), $filename);
                DB::table('dokter')->where('id', $dokter->id)->update(['tanda_tangan' => 'tanda_tangan/' . $filename]);
            }
        });

        return redirect()->route('admin.dokter.show', $dokter->id)
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    /**
     * Generate jadwal operasional untuk hari-hari yang belum ada,
     * dengan nilai default dari jadwal_sistem.
     */
    public function generateJadwal($id)
    {
        $dokter = Dokter::with('jadwalDokters')->findOrFail($id);

        $hariSemua    = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $hariSudahAda = $dokter->jadwalDokters->pluck('hari')->toArray();
        $hariBelumAda = array_diff($hariSemua, $hariSudahAda);

        if (empty($hariBelumAda)) {
            return redirect()->route('admin.dokter.show', $id)
                ->with('info', 'Semua hari sudah memiliki jadwal operasional.');
        }

        $jadwalSistems = \App\Models\JadwalSistem::harian()
            ->whereIn('hari', $hariBelumAda)
            ->get()
            ->keyBy('hari');

        DB::transaction(function () use ($dokter, $hariBelumAda, $jadwalSistems) {
            foreach ($hariBelumAda as $hari) {
                $js               = $jadwalSistems->get($hari);
                $isAktif          = 1;
                $jamMulai         = 0;
                $jamSelesai       = 0;
                $istirahatMulai   = null;
                $istirahatSelesai = null;

                if ($js && !$js->is_libur && $js->jam_buka !== null && $js->jam_tutup !== null) {
                    $jamMulai         = $js->jam_buka;
                    $jamSelesai       = $js->jam_tutup;
                    $istirahatMulai   = $js->jam_istirahat_mulai;
                    $istirahatSelesai = $js->jam_istirahat_selesai;
                } else {
                    $isAktif = 0;
                }

                DB::table('jadwal_dokter')->insert([
                    'id_dokter'                  => $dokter->id,
                    'hari'                       => $hari,
                    'jam_mulai'                  => $jamMulai,
                    'jam_selesai'                => $jamSelesai,
                    'override_istirahat_mulai'   => $istirahatMulai,
                    'override_istirahat_selesai' => $istirahatSelesai,
                    'is_aktif'                   => $isAktif,
                ]);
            }
        });

        $jumlah = count($hariBelumAda);
        return redirect()->route('admin.dokter.show', $id)
            ->with('success', "{$jumlah} jadwal operasional baru berhasil ditambahkan.");
    }

    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);

        DB::transaction(function () use ($dokter) {
            // Hapus data cuti
            $dokter->cutiDokters()->delete();

            // Set null id_dokter di jadwal
            $dokter->jadwals()->update(['id_dokter' => null]);

            // Hapus data jadwalDokters jika ada
            $dokter->jadwalDokters()->delete();

            // Hapus file-file dari disk
            foreach (['dokumen_sip', 'foto_profil', 'tanda_tangan'] as $field) {
                if ($dokter->$field && File::exists(public_path($dokter->$field))) {
                    File::delete(public_path($dokter->$field));
                }
            }

            // Hapus dokter
            $dokter->delete();

            // Hapus user
            if ($dokter->user) {
                $dokter->user->delete();
            }
        });

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil dihapus.');
    }
}
