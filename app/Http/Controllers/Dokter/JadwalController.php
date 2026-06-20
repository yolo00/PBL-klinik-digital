<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    /**
     * Skenario: Melihat Jadwal Dokter
     * - Jika ada jadwal → tampilkan daftar
     * - Jika tidak ada jadwal → tampilkan pesan kosong (empty state)
     * - Jadwal difilter berdasarkan dokter yang login
     */
    public function index(Request $request)
    {
        $dokterId = auth()->user()->dokter->id;
        $filter   = $request->input('filter', 'semua'); // semua | hari_ini | menunggu

        $query = Jadwal::with(['pasien.user', 'rekamMedis'])
            ->where('id_dokter', $dokterId);

        // Filter opsional
        if ($filter === 'hari_ini') {
            $query->whereDate('tanggal', now()->toDateString());
        } elseif ($filter === 'menunggu') {
            $query->whereIn('status', ['menunggu', 'dikonfirmasi']);
        }

        $jadwals = $query->orderBy('tanggal', 'desc')
                         ->orderBy('jam', 'asc')
                         ->paginate(15)
                         ->withQueryString();

        return view('dokter.jadwal-saya', compact('jadwals', 'filter'));
    }
}
