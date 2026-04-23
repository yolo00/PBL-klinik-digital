<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class AdminRekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $query = RekamMedis::with('jadwal.dokter.user', 'jadwal.pasien.user');

        // Pencarian nama pasien
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('jadwal.pasien.user', fn($q) => $q->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('jadwal.dokter.user', fn($q) => $q->where('nama', 'like', "%{$search}%"));
        }

        // Sortir
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'terlama' => $query->orderBy('created_at', 'asc'),
            default   => $query->orderByDesc('created_at'),
        };

        $rekamMedis = $query->paginate(10)->withQueryString();

        return view('admin.rekam-medis', compact('rekamMedis'));
    }

    public function create()
    {
        // Hanya tampilkan jadwal yang sudah 'selesai' dan belum punya rekam medis
        $jadwals = Jadwal::with('dokter.user', 'pasien.user')
            ->where('status', 'selesai')
            ->whereDoesntHave('rekamMedis')
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.rekam-medis-create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id_jadwal|unique:rekam_medis,id_jadwal',
            'keluhan'   => 'nullable|string',
            'diagnosa'  => 'nullable|string',
            'catatan'   => 'nullable|string',
        ], [
            'id_jadwal.required' => 'Jadwal wajib dipilih.',
            'id_jadwal.exists'   => 'Jadwal tidak ditemukan.',
            'id_jadwal.unique'   => 'Rekam medis untuk jadwal ini sudah ada.',
        ]);

        RekamMedis::create([
            'id_jadwal' => $request->id_jadwal,
            'keluhan'   => $request->keluhan,
            'diagnosa'  => $request->diagnosa,
            'catatan'   => $request->catatan,
        ]);

        return redirect()->route('admin.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function show($id)
    {
        $rekamMedis = RekamMedis::with(
            'jadwal.dokter.user',
            'jadwal.pasien.user',
            'reseps'
        )->findOrFail($id);

        return view('admin.rekam-medis-detail', compact('rekamMedis'));
    }

    public function edit($id)
    {
        $rekamMedis = RekamMedis::with('jadwal.dokter.user', 'jadwal.pasien.user')
            ->findOrFail($id);

        $jadwals = Jadwal::with('dokter.user', 'pasien.user')
            ->where('status', 'selesai')
            ->where(function ($q) use ($rekamMedis) {
                $q->whereDoesntHave('rekamMedis')
                  ->orWhere('id_jadwal', $rekamMedis->id_jadwal);
            })
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.rekam-medis-edit', compact('rekamMedis', 'jadwals'));
    }
}
