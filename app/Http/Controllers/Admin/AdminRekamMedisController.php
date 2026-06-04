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
        $query = RekamMedis::with([
            'jadwal.dokter.user',
            'jadwal.pasien.user',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('jadwal.pasien.user', fn($sq) => $sq->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('jadwal.dokter.user', fn($sq) => $sq->where('nama', 'like', "%{$search}%"));
            });
        }

        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderByDesc('created_at');
        }

        $rekamMedis = $query->paginate(10)->withQueryString();

        return view('admin.rekam-medis.index', compact('rekamMedis'));
    }


    public function create()
    {
        $jadwals = Jadwal::with('dokter.user', 'pasien.user')
            ->where('status', 'selesai')
            ->whereDoesntHave('rekamMedis')
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.rekam-medis.create', compact('jadwals'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id|unique:rekam_medis,id_jadwal',
            'keluhan'   => 'nullable|string|max:2000',
            'diagnosa'  => 'nullable|string|max:2000',
            'catatan'   => 'nullable|string|max:2000',
        ], [
            'id_jadwal.required' => 'Jadwal wajib dipilih.',
            'id_jadwal.exists'   => 'Jadwal tidak ditemukan.',
            'id_jadwal.unique'   => 'Rekam medis untuk jadwal ini sudah ada.',
        ]);

        RekamMedis::create([
            'id_jadwal'  => $validated['id_jadwal'],
            'keluhan'    => $validated['keluhan'],
            'diagnosa'   => $validated['diagnosa'],
            'catatan'    => $validated['catatan'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function show($id)
    {
        $rekamMedis = RekamMedis::with([
            'jadwal.dokter.user',
            'jadwal.dokter.spesialisasi',
            'jadwal.pasien.user',
            'reseps',
            'createdBy',
            'updatedBy',
        ])->findOrFail($id);

        return view('admin.rekam-medis.detail', compact('rekamMedis'));
    }


    public function edit($id)
    {
        $rekamMedis = RekamMedis::with([
            'jadwal.dokter.user',
            'jadwal.pasien.user',
        ])->findOrFail($id);

        // Jadwal yang tersedia: belum ada rekam medis, atau jadwal milik rekam ini sendiri
        $jadwals = Jadwal::with('dokter.user', 'pasien.user')
            ->where('status', 'selesai')
            ->where(function ($q) use ($rekamMedis) {
                $q->whereDoesntHave('rekamMedis')
                  ->orWhere('id', $rekamMedis->id_jadwal);
            })
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.rekam-medis.edit', compact('rekamMedis', 'jadwals'));
    }


    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        $validated = $request->validate([
            'id_jadwal' => [
                'required',
                'exists:jadwal,id',
                // Unik kecuali rekam medis ini sendiri
                \Illuminate\Validation\Rule::unique('rekam_medis', 'id_jadwal')->ignore($rekamMedis->id),
            ],
            'keluhan'   => 'nullable|string|max:2000',
            'diagnosa'  => 'nullable|string|max:2000',
            'catatan'   => 'nullable|string|max:2000',
        ], [
            'id_jadwal.required' => 'Jadwal wajib dipilih.',
            'id_jadwal.exists'   => 'Jadwal tidak ditemukan.',
            'id_jadwal.unique'   => 'Rekam medis untuk jadwal ini sudah ada.',
        ]);

        $rekamMedis->update([
            'id_jadwal'  => $validated['id_jadwal'],
            'keluhan'    => $validated['keluhan'],
            'diagnosa'   => $validated['diagnosa'],
            'catatan'    => $validated['catatan'],
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.rekam-medis.show', $id)
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        $rekamMedis->reseps()->delete();
        $rekamMedis->delete();

        return redirect()->route('admin.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dihapus.');
    }
}