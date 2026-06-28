<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\AkunUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminPasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::with('user')
            ->join('akun_user', 'pasien.id_user', '=', 'akun_user.id')
            ->select('pasien.*');

        if ($request->filled('jenis_kelamin')) {
            $query->where('akun_user.jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('akun_user.nama', 'like', "%{$search}%")
                  ->orWhere('akun_user.no_hp', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'nama_asc'  => $query->orderBy('akun_user.nama', 'asc'),
            'nama_desc' => $query->orderBy('akun_user.nama', 'desc'),
            default     => $query->orderByDesc('pasien.id'),
        };

        $pasiens = $query->paginate(10)->withQueryString();

        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'             => 'required|string|max:100',
            'email'            => 'required|email|unique:akun_user,email',
            'password'         => 'required|string|min:6',
            'no_hp'            => 'required|string|max:15',
            'jenis_kelamin'    => 'required|in:L,P',
            'tgl_lahir'        => 'required|date',
            'gol_darah'        => 'nullable|in:A,B,AB,O',
            'riwayat_penyakit' => 'nullable|string',
            'alergi'           => 'nullable|array',
            'alergi.*'         => 'nullable|string|max:100',
        ], [
            'nama.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'no_hp.required'         => 'Nomor HP wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'tgl_lahir.required'     => 'Tanggal lahir wajib diisi.',
            'alergi.*.max'           => 'Nama alergi maksimal 100 karakter.',
        ]);

        DB::transaction(function () use ($request) {
            $userId = DB::table('akun_user')->insertGetId([
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'nama'          => $request->nama,
                'no_hp'         => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tgl_lahir'     => $request->tgl_lahir,
                'role'          => 'P',
                'created_at'    => now(),
            ]);

            $pasienId = DB::table('pasien')->insertGetId([
                'id_user'          => $userId,
                'gol_darah'        => $request->gol_darah,
                'riwayat_penyakit' => $request->riwayat_penyakit,
            ]);

            // Simpan data alergi (skip entri kosong)
            $alergiList = collect($request->input('alergi', []))
                ->map(fn($a) => trim($a))
                ->filter()
                ->values();

            foreach ($alergiList as $namaAlergi) {
                DB::table('alergi')->insert([
                    'id_pasien'   => $pasienId,
                    'nama_alergi' => $namaAlergi,
                ]);
            }
        });

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pasien = Pasien::with([
            'user',
            'alergi',
            'jadwals.dokter.user',
            'jadwals.rekamMedis',
        ])->findOrFail($id);

        return view('admin.pasien.detail', compact('pasien'));
    }

    public function edit($id)
    {
        $pasien = Pasien::with(['user', 'alergi'])->findOrFail($id);

        $alergiTampil = old('alergi') !== null
            ? old('alergi')
            : $pasien->alergi->pluck('nama_alergi')->toArray();

        return view('admin.pasien.edit', compact('pasien', 'alergiTampil'));
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::with(['user', 'alergi'])->findOrFail($id);

        $request->validate([
            'nama'             => 'required|string|max:100',
            'email'            => 'required|email|unique:akun_user,email,' . $pasien->id_user,
            'password'         => 'nullable|string|min:6',
            'no_hp'            => 'required|string|max:15',
            'jenis_kelamin'    => 'required|in:L,P',
            'tgl_lahir'        => 'required|date',
            'gol_darah'        => 'nullable|in:A,B,AB,O',
            'riwayat_penyakit' => 'nullable|string',
            'alergi'           => 'nullable|array',
            'alergi.*'         => 'nullable|string|max:100',
        ], [
            'nama.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.min'           => 'Password minimal 6 karakter.',
            'no_hp.required'         => 'Nomor HP wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'tgl_lahir.required'     => 'Tanggal lahir wajib diisi.',
            'alergi.*.max'           => 'Nama alergi maksimal 100 karakter.',
        ]);

        DB::transaction(function () use ($request, $pasien) {
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
                ->where('id', $pasien->id_user)
                ->update($userData);

            DB::table('pasien')
                ->where('id', $pasien->id)
                ->update([
                    'gol_darah'        => $request->gol_darah,
                    'riwayat_penyakit' => $request->riwayat_penyakit,
                ]);

            // Strategi replace: hapus semua alergi lama, masukkan yang baru
            DB::table('alergi')->where('id_pasien', $pasien->id)->delete();

            $alergiList = collect($request->input('alergi', []))
                ->map(fn($a) => trim($a))
                ->filter()
                ->values();

            foreach ($alergiList as $namaAlergi) {
                DB::table('alergi')->insert([
                    'id_pasien'   => $pasien->id,
                    'nama_alergi' => $namaAlergi,
                ]);
            }
        });

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);

        DB::transaction(function () use ($pasien) {
            // Hapus data alergi
            $pasien->alergi()->delete();

            // Set null id_pasien di jadwal agar tidak error foreign key
            $pasien->jadwals()->update(['id_pasien' => null]);

            // Hapus pasien
            $pasien->delete();

            // Hapus user
            if ($pasien->user) {
                $pasien->user->delete();
            }
        });

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}