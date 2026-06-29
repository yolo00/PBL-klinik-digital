<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CutiDokter;
use App\Models\Notifikasi;
use App\Models\AkunUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Auth;

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
        $cuti = CutiDokter::with('dokter.user')->findOrFail($id);

        if ($cuti->status !== 'pending') {
            return redirect()->route('admin.cuti-dokter.show', $id)
                ->with('error', 'Hanya pengajuan dengan status pending yang dapat disetujui.');
        }

        $cuti->update(['status' => 'disetujui']);

        // ── NOTIFIKASI: beritahu dokter bahwa cuti disetujui ────
        if ($cuti->dokter && $cuti->dokter->id_user) {
            $dari   = \Carbon\Carbon::parse($cuti->dari_tanggal)->translatedFormat('d F Y');
            $sampai = \Carbon\Carbon::parse($cuti->sampai_tanggal)->translatedFormat('d F Y');

            Notifikasi::kirim([
                'type'      => 'Pengajuan Cuti Disetujui',
                'message'   => "Pengajuan cuti Anda dari {$dari} s/d {$sampai} telah disetujui oleh admin.",
                'ref_tabel' => 'cuti_dokter',
                'ref_id'    => $cuti->id,
                'is_urgent' => 0,
                'created_by'=> Auth::id(),
            ], $cuti->dokter->id_user);
        }
        // ────────────────────────────────────────────────────────

        return redirect()->route('admin.cuti-dokter.show', $id)
            ->with('success', 'Pengajuan cuti dokter telah disetujui.');
    }


    public function reject($id)
    {
        $cuti = CutiDokter::with('dokter.user')->findOrFail($id);

        if ($cuti->status !== 'pending') {
            return redirect()->route('admin.cuti-dokter.show', $id)
                ->with('error', 'Hanya pengajuan dengan status pending yang dapat ditolak.');
        }

        $cuti->update(['status' => 'ditolak']);

        // ── NOTIFIKASI: beritahu dokter bahwa cuti ditolak ──────
        if ($cuti->dokter && $cuti->dokter->id_user) {
            $dari   = \Carbon\Carbon::parse($cuti->dari_tanggal)->translatedFormat('d F Y');
            $sampai = \Carbon\Carbon::parse($cuti->sampai_tanggal)->translatedFormat('d F Y');

            Notifikasi::kirim([
                'type'      => 'Pengajuan Cuti Ditolak',
                'message'   => "Pengajuan cuti Anda dari {$dari} s/d {$sampai} telah ditolak oleh admin.",
                'ref_tabel' => 'cuti_dokter',
                'ref_id'    => $cuti->id,
                'is_urgent' => 0,
                'created_by'=> Auth::id(),
            ], $cuti->dokter->id_user);
        }
        // ────────────────────────────────────────────────────────

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
