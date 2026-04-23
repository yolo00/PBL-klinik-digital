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
            ->join('akun_user', 'pasien.id_user', '=', 'akun_user.id_user')
            ->select('pasien.*');

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('akun_user.jenis_kelamin', $request->jenis_kelamin);
        }

        // Pencarian nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('akun_user.nama', 'like', "%{$search}%")
                  ->orWhere('pasien.nimnik', 'like', "%{$search}%");
            });
        }

        // Sortir
        $sort = $request->get('sort', 'nama_asc');
        match ($sort) {
            'nama_desc' => $query->orderBy('akun_user.nama', 'desc'),
            'terbaru'   => $query->orderByDesc('pasien.id_pasien'),
            default     => $query->orderBy('akun_user.nama', 'asc'),
        };

        $pasiens = $query->paginate(10)->withQueryString();

        return view('admin.pasien', compact('pasiens'));
    }

    public function create()
    {
        return view('admin.pasien-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email|unique:akun_user,email',
            'password'      => 'required|string|min:6',
            'nimnik'        => 'required|string|max:20',
            'no_hp'         => 'required|string|max:15',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir'     => 'required|date',
        ], [
            'nama.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'nimnik.required'        => 'NIM/NIK wajib diisi.',
            'no_hp.required'         => 'Nomor HP wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'tgl_lahir.required'     => 'Tanggal lahir wajib diisi.',
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

            DB::table('pasien')->insert([
                'id_user' => $userId,
                'nimnik'  => $request->nimnik,
            ]);
        });

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pasien = Pasien::with('user', 'jadwals.dokter.user', 'jadwals.rekamMedis')
            ->findOrFail($id);

        return view('admin.pasien-detail', compact('pasien'));
    }

    public function edit($id)
    {
        $pasien = Pasien::with('user')->findOrFail($id);

        return view('admin.pasien-edit', compact('pasien'));
    }
}
