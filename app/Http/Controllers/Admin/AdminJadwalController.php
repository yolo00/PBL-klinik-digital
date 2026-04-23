<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminJadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with('dokter.user', 'pasien.user');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama pasien/dokter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pasien.user', fn($q) => $q->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('dokter.user', fn($q) => $q->where('nama', 'like', "%{$search}%"));
        }

        // Sortir
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'terlama' => $query->orderBy('tanggal', 'asc')->orderBy('jam', 'asc'),
            default   => $query->orderByDesc('tanggal')->orderByDesc('jam'),
        };

        $jadwals = $query->paginate(10)->withQueryString();

        return view('admin.jadwal', compact('jadwals'));
    }

    public function create()
    {
        $dokters = Dokter::with('user')
            ->join('akun_user', 'dokter.id_user', '=', 'akun_user.id_user')
            ->orderBy('akun_user.nama')
            ->select('dokter.*')
            ->get();

        $pasiens = Pasien::with('user')
            ->join('akun_user', 'pasien.id_user', '=', 'akun_user.id_user')
            ->orderBy('akun_user.nama')
            ->select('pasien.*')
            ->get();

        return view('admin.jadwal-create', compact('dokters', 'pasiens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required|exists:dokter,id_dokter',
            'id_pasien' => 'nullable|exists:pasien,id_pasien',
            'tanggal'   => 'required|date',
            'jam'       => 'required',
            'status'    => 'required|in:menunggu,dikonfirmasi,selesai,dibatalkan',
        ], [
            'id_dokter.required' => 'Dokter wajib dipilih.',
            'id_dokter.exists'   => 'Dokter tidak ditemukan.',
            'tanggal.required'   => 'Tanggal wajib diisi.',
            'jam.required'       => 'Jam wajib diisi.',
            'status.required'    => 'Status wajib dipilih.',
        ]);

        Jadwal::create([
            'id_dokter' => $request->id_dokter,
            'id_pasien' => $request->id_pasien ?: null,
            'tanggal'   => $request->tanggal,
            'jam'       => $request->jam,
            'status'    => $request->status,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(
            'dokter.user',
            'pasien.user',
            'rekamMedis',
            'pembayaran'
        )->findOrFail($id);

        return view('admin.jadwal-detail', compact('jadwal'));
    }

    public function edit($id)
    {
        $jadwal = Jadwal::with('dokter.user', 'pasien.user')->findOrFail($id);

        $dokters = Dokter::with('user')
            ->join('akun_user', 'dokter.id_user', '=', 'akun_user.id_user')
            ->orderBy('akun_user.nama')
            ->select('dokter.*')
            ->get();

        $pasiens = Pasien::with('user')
            ->join('akun_user', 'pasien.id_user', '=', 'akun_user.id_user')
            ->orderBy('akun_user.nama')
            ->select('pasien.*')
            ->get();

        return view('admin.jadwal-edit', compact('jadwal', 'dokters', 'pasiens'));
    }
}
