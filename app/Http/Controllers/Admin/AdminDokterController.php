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
        $sort = $request->get('sort', 'nama_asc');
        match ($sort) {
            'nama_desc' => $query->orderBy('akun_user.nama', 'desc'),
            default     => $query->orderBy('akun_user.nama', 'asc'),
        };

        $dokters = $query->paginate(10)->withQueryString();

        return view('admin.dokter', compact('dokters'));
    }

    public function create()
    {
        $spesialisasis = Spesialisasi::all();
        return view('admin.dokter-create', compact('spesialisasis'));
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
            'dokumen_sip'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
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

            DB::table('dokter')->insert([
                'id_user'          => $userId,
                'id_spesialisasi'  => $request->id_spesialisasi,
            ]);

            // Upload dokumen SIP jika ada
            if ($request->hasFile('dokumen_sip')) {
                $file = $request->file('dokumen_sip');
                $filename = 'sip_' . time() . '_' . $userId . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('sip'), $filename);

                DB::table('dokter')
                    ->where('id_user', $userId)
                    ->update(['dokumen_sip' => 'sip/' . $filename]);
            }
        });

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function show($id)
    {
        $dokter = Dokter::with(['user', 'spesialisasi', 'jadwals.pasien.user', 'cutiDokters'])
            ->findOrFail($id);

        return view('admin.dokter-detail', compact('dokter'));
    }

    public function edit($id)
    {
        $dokter = Dokter::with(['user', 'spesialisasi'])->findOrFail($id);
        $spesialisasis = Spesialisasi::all();

        return view('admin.dokter-edit', compact('dokter', 'spesialisasis'));
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
            'dokumen_sip'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
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
                ]);

            // Upload dokumen SIP baru jika ada
            if ($request->hasFile('dokumen_sip')) {
                // Hapus file lama
                if ($dokter->dokumen_sip && File::exists(public_path($dokter->dokumen_sip))) {
                    File::delete(public_path($dokter->dokumen_sip));
                }

                $file = $request->file('dokumen_sip');
                $filename = 'sip_' . time() . '_' . $dokter->id_user . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('sip'), $filename);

                DB::table('dokter')
                    ->where('id', $dokter->id)
                    ->update(['dokumen_sip' => 'sip/' . $filename]);
            }
        });

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui.');
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

            // Hapus dokumen SIP dari disk
            if ($dokter->dokumen_sip && File::exists(public_path($dokter->dokumen_sip))) {
                File::delete(public_path($dokter->dokumen_sip));
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
