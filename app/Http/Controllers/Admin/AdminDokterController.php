<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminDokterController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokter::with('user')
            ->join('akun_user', 'dokter.id_user', '=', 'akun_user.id_user')
            ->select('dokter.*');

        // Pencarian nama atau spesialis
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('akun_user.nama', 'like', "%{$search}%")
                  ->orWhere('dokter.spesialis', 'like', "%{$search}%");
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
        return view('admin.dokter-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email|unique:akun_user,email',
            'password'      => 'required|string|min:6',
            'spesialis'     => 'required|string|max:100',
            'no_hp'         => 'required|string|max:15',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir'     => 'required|date',
        ], [
            'nama.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'spesialis.required'     => 'Spesialis wajib diisi.',
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
                'role'          => 'D',
                'created_at'    => now(),
            ]);

            DB::table('dokter')->insert([
                'id_user'   => $userId,
                'spesialis' => $request->spesialis,
            ]);
        });

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function show($id)
    {
        $dokter = Dokter::with('user', 'jadwals.pasien.user', 'cutiDokters')
            ->findOrFail($id);

        return view('admin.dokter-detail', compact('dokter'));
    }

    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);

        return view('admin.dokter-edit', compact('dokter'));
    }
}
