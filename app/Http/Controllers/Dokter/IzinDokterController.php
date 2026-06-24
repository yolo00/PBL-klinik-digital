<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\CutiDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IzinDokterController extends Controller
{
    /**
     * GET /dokter/cuti
     * Menampilkan form pengajuan cuti + riwayat pengajuan cuti.
     */
    public function index(Request $request)
    {
        $dokterId = auth()->user()->dokter->id;

        $query = CutiDokter::where('id_dokter', $dokterId)
            ->orderByDesc('created_at');

        $cutis = $query->paginate(10)->withQueryString();

        return view('dokter.pengaturan-jadwal', compact('cutis'));
    }

    /**
     * POST /dokter/cuti
     * Menyimpan pengajuan cuti.
     */
    public function store(Request $request)
    {
        $dokterId = auth()->user()->dokter->id;
        $today = now()->toDateString();

        $validated = $request->validate([
            'dari_tanggal'   => ['required', 'date', 'after_or_equal:' . $today],
            'sampai_tanggal' => ['nullable', 'date', 'after_or_equal:dari_tanggal'],
            'alasan'          => ['nullable', 'string', 'max:500'],
        ], [
            'dari_tanggal.required' => 'Tanggal mulai wajib diisi.',
            'dari_tanggal.after_or_equal' => 'Tanggal mulai tidak boleh berlalu.',
            'sampai_tanggal.after_or_equal' => 'Tanggal sampai harus sama atau setelah tanggal mulai.',
        ]);

        $dari = $validated['dari_tanggal'];
        $sampai = $validated['sampai_tanggal'] ?? null;

        // Jika cuti sehari, requirement: 'sampai_tanggal' boleh kosong.
        if (empty($sampai)) {
            $sampai = $dari;
        }

        CutiDokter::create([
            'id_dokter'      => $dokterId,
            'dari_tanggal'  => $dari,
            'sampai_tanggal'=> $sampai,
            'alasan'         => $validated['alasan'] ?? null,
            'status'         => 'pending',
        ]);

        return redirect()
            ->route('dokter.pengaturan')
            ->with('success', 'Pengajuan cuti Anda berhasil diajukan (status: Pending).');
    }
}

