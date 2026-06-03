<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSistem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminJadwalSistemController extends Controller
{
    public function index(Request $request)
    {
        // Jadwal harian (Senin–Minggu), diurutkan berdasarkan urutan hari
        $urutan      = JadwalSistem::urutanHari();
        $jadwalHarian = JadwalSistem::harian()
            ->get()
            ->sortBy(fn($j) => $urutan[$j->hari] ?? 99)
            ->values();

        // Bulan & tahun untuk kalender
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun',  now()->year);

        // Tanggal khusus dalam bulan yang ditampilkan (untuk kalender)
        $tanggalKhususBulan = JadwalSistem::tanggalKhusus()
            ->whereYear('tgl_khusus', $tahun)
            ->whereMonth('tgl_khusus', $bulan)
            ->get()
            ->keyBy(fn($j) => Carbon::parse($j->tgl_khusus)->format('Y-m-d'));

        // ── Tabel tanggal khusus: search + filter ──
        $query = JadwalSistem::tanggalKhusus();

        if ($search = trim($request->get('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($filterTanggal = $request->get('filter_tanggal')) {
            $query->whereDate('tgl_khusus', $filterTanggal);
        }

        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'terlama'   => $query->orderBy('id', 'asc'),
            'mendekati' => $query->orderByRaw('ABS(DATEDIFF(tgl_khusus, CURDATE())) ASC'),
            default     => $query->orderBy('id', 'desc'),
        };

        $jadwalKhusus = $query->paginate(10)->withQueryString();

        return view('admin.jadwal-sistem.index', compact(
            'jadwalHarian',
            'jadwalKhusus',
            'tanggalKhususBulan',
            'bulan',
            'tahun',
        ));
    }

    // ── Edit Jadwal Harian (jam klinik per hari) ──────────────────────────────

    public function editHarian(JadwalSistem $jadwalSistem)
    {
        abort_unless($jadwalSistem->hari !== null && $jadwalSistem->tgl_khusus === null, 403);

        return view('admin.jadwal-sistem.form-harian', [
            'jadwal' => $jadwalSistem,
        ]);
    }

    public function updateHarian(Request $request, JadwalSistem $jadwalSistem)
    {
        abort_unless($jadwalSistem->hari !== null && $jadwalSistem->tgl_khusus === null, 403);

        $validated = $request->validate([
            'jam_buka'             => 'required|integer|min:0|max:23',
            'jam_tutup'            => 'required|integer|min:0|max:23|gt:jam_buka',
            'jam_istirahat_mulai'  => 'nullable|integer|min:0|max:23',
            'jam_istirahat_selesai'=> 'nullable|integer|min:0|max:23|gt:jam_istirahat_mulai',
            'is_libur'             => 'boolean',
        ], [
            'jam_tutup.gt'              => 'Jam tutup harus lebih besar dari jam buka.',
            'jam_istirahat_selesai.gt'  => 'Jam istirahat selesai harus lebih besar dari jam mulai.',
        ]);

        // Kalau libur, kosongkan jam
        if (!empty($validated['is_libur'])) {
            $validated['jam_buka'] = $validated['jam_tutup'] = null;
            $validated['jam_istirahat_mulai'] = $validated['jam_istirahat_selesai'] = null;
        }

        $jadwalSistem->update($validated);

        return redirect()
            ->route('admin.jadwal-sistem')
            ->with('success', 'Jam operasional ' . $jadwalSistem->hari . ' berhasil diperbarui.');
    }

    // ── Create Tanggal Khusus ─────────────────────────────────────────────────

    public function create()
    {
        return view('admin.jadwal-sistem.form', [
            'jadwal' => null,
            'mode'   => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateKhusus($request);
        $this->sealIfLibur($validated);

        JadwalSistem::create($validated);

        return redirect()
            ->route('admin.jadwal-sistem')
            ->with('success', 'Jadwal tanggal khusus berhasil ditambahkan.');
    }

    // ── Edit Tanggal Khusus ────────────────────────────────────────────────

    public function edit(JadwalSistem $jadwalSistem)
    {
        abort_unless($jadwalSistem->tgl_khusus !== null, 403, 'Hanya tanggal khusus yang dapat diedit di sini.');

        return view('admin.jadwal-sistem.form', [
            'jadwal' => $jadwalSistem,
            'mode'   => 'edit',
        ]);
    }

    public function update(Request $request, JadwalSistem $jadwalSistem)
    {
        abort_unless($jadwalSistem->tgl_khusus !== null, 403);

        $validated = $this->validateKhusus($request, $jadwalSistem->id);
        $this->sealIfLibur($validated);

        $jadwalSistem->update($validated);

        return redirect()
            ->route('admin.jadwal-sistem')
            ->with('success', 'Jadwal tanggal khusus berhasil diperbarui.');
    }

    // ── Delete ────────────────────────────────────────────────────────────────

    public function destroy(JadwalSistem $jadwalSistem)
    {
        abort_if($jadwalSistem->tgl_khusus === null, 403, 'Jadwal harian tidak dapat dihapus.');

        $jadwalSistem->delete();

        return redirect()
            ->route('admin.jadwal-sistem')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function validateKhusus(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'tgl_khusus' => [
                'required', 'date',
                \Illuminate\Validation\Rule::unique('jadwal_sistem', 'tgl_khusus')->ignore($ignoreId),
            ],
            'is_libur'             => 'boolean',
            'jam_buka'             => 'nullable|integer|min:0|max:23',
            'jam_tutup'            => 'nullable|integer|min:0|max:23|gt:jam_buka',
            'jam_istirahat_mulai'  => 'nullable|integer|min:0|max:23',
            'jam_istirahat_selesai'=> 'nullable|integer|min:0|max:23|gt:jam_istirahat_mulai',
            'keterangan'           => 'nullable|string|max:100',
        ], [
            'tgl_khusus.unique'         => 'Tanggal ini sudah memiliki jadwal khusus.',
            'jam_tutup.gt'              => 'Jam tutup harus lebih besar dari jam buka.',
            'jam_istirahat_selesai.gt'  => 'Jam istirahat selesai harus lebih besar dari jam mulai.',
        ]);
    }

    /** Kalau is_libur aktif, kosongkan semua kolom jam */
    private function sealIfLibur(array &$data): void
    {
        if (!empty($data['is_libur'])) {
            $data['jam_buka'] = $data['jam_tutup'] = null;
            $data['jam_istirahat_mulai'] = $data['jam_istirahat_selesai'] = null;
        }
        // Pastikan hari null untuk tanggal khusus
        $data['hari'] = null;
    }
}
