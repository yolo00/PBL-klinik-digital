<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CutiDokter;
use Illuminate\Http\Request;

class AdminCutiDokterController extends Controller
{
    public function index(Request $request)
    {
        $query = CutiDokter::with('dokter.user', 'dokter.spesialisasi');

        // Filter berdasarkan nama dokter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('dokter.user', fn($q) => $q->where('nama', 'like', "%{$search}%"));
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sortir
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'terlama' => $query->orderBy('created_at', 'asc'),
            default   => $query->orderByDesc('created_at'),
        };

        $cutis = $query->paginate(10)->withQueryString();

        return view('admin.cuti_dokter.index', compact('cutis'));
    }

    public function show($id)
    {
        $cuti = CutiDokter::with('dokter.user', 'dokter.spesialisasi')->findOrFail($id);

        return view('admin.cuti_dokter.show', compact('cuti'));
    }

    public function approve($id)
    {
        $cuti = CutiDokter::findOrFail($id);

        if ($cuti->status !== 'pending') {
            return redirect()->route('admin.cuti-dokter.show', $id)
                ->with('error', 'Hanya pengajuan dengan status pending yang dapat disetujui.');
        }

        $cuti->update(['status' => 'disetujui']);

        return redirect()->route('admin.cuti-dokter.show', $id)
            ->with('success', 'Pengajuan cuti dokter telah disetujui.');
    }

    public function reject($id)
    {
        $cuti = CutiDokter::findOrFail($id);

        if ($cuti->status !== 'pending') {
            return redirect()->route('admin.cuti-dokter.show', $id)
                ->with('error', 'Hanya pengajuan dengan status pending yang dapat ditolak.');
        }

        $cuti->update(['status' => 'ditolak']);

        return redirect()->route('admin.cuti-dokter.show', $id)
            ->with('success', 'Pengajuan cuti dokter telah ditolak.');
    }

    public function destroy($id)
    {
        $cuti = CutiDokter::findOrFail($id);
        $cuti->delete();

        return redirect()->route('admin.cuti-dokter.index')
            ->with('success', 'Data cuti dokter berhasil dihapus.');
    }
}
