<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;

class AdminJadwalController extends Controller
{
    // ─── Index ────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Jadwal::with([
            'dokter.user',
            'pasien.user',
        ]);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama pasien / dokter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pasien.user', fn($sq) => $sq->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('dokter.user', fn($sq) => $sq->where('nama', 'like', "%{$search}%"));
            });
        }

        // Sortir
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('tanggal', 'asc')->orderBy('jam', 'asc');
        } else {
            $query->orderByDesc('tanggal')->orderByDesc('jam');
        }

        $jadwals = $query->paginate(10)->withQueryString();

        return view('admin.jadwal', compact('jadwals'));
    }

    // ─── Create ───────────────────────────────────────────────

    public function create()
    {
        // Ambil dokter berikut nama user — join ke akun_user.id (bukan id_user)
        $dokters = Dokter::with(['user', 'spesialisasi'])
            ->join('akun_user', 'dokter.id_user', '=', 'akun_user.id')
            ->orderBy('akun_user.nama')
            ->select('dokter.*')
            ->get();

        $pasiens = Pasien::with('user')
            ->join('akun_user', 'pasien.id_user', '=', 'akun_user.id')
            ->orderBy('akun_user.nama')
            ->select('pasien.*')
            ->get();

        return view('admin.jadwal-create', compact('dokters', 'pasiens'));
    }

    // ─── Store ────────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_dokter' => 'required|exists:dokter,id',
            'id_pasien' => 'nullable|exists:pasien,id',
            'tanggal'   => 'required|date',
            'jam'       => 'required|integer|min:0|max:23',
            'status'    => 'required|in:menunggu,dikonfirmasi,selesai,dibatalkan',
        ], [
            'id_dokter.required' => 'Dokter wajib dipilih.',
            'id_dokter.exists'   => 'Dokter tidak ditemukan.',
            'tanggal.required'   => 'Tanggal wajib diisi.',
            'tanggal.date'       => 'Format tanggal tidak valid.',
            'jam.required'       => 'Jam wajib dipilih.',
            'jam.integer'        => 'Jam tidak valid.',
            'status.required'    => 'Status wajib dipilih.',
            'status.in'          => 'Status tidak valid.',
        ]);

        // Cek konflik slot (dokter + tanggal + jam harus unik)
        $konflik = Jadwal::where('id_dokter', $validated['id_dokter'])
            ->where('tanggal', $validated['tanggal'])
            ->where('jam', $validated['jam'])
            ->exists();

        if ($konflik) {
            return back()
                ->withInput()
                ->withErrors(['jam' => 'Slot jam tersebut sudah terisi untuk dokter dan tanggal yang dipilih.']);
        }

        Jadwal::create([
            'id_dokter' => $validated['id_dokter'],
            'id_pasien' => $validated['id_pasien'] ?: null,
            'tanggal'   => $validated['tanggal'],
            'jam'       => (int) $validated['jam'],
            'status'    => $validated['status'],
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // ─── Show ─────────────────────────────────────────────────

    public function show($id)
    {
        $jadwal = Jadwal::with([
            'dokter.user',
            'dokter.spesialisasi',
            'pasien.user',
            'rekamMedis',
            'pembayaran',
        ])->findOrFail($id);

        return view('admin.jadwal-detail', compact('jadwal'));
    }

    // ─── Edit ─────────────────────────────────────────────────

    public function edit($id)
    {
        $jadwal = Jadwal::with(['dokter.user', 'pasien.user'])->findOrFail($id);

        $dokters = Dokter::with(['user', 'spesialisasi'])
            ->join('akun_user', 'dokter.id_user', '=', 'akun_user.id')
            ->orderBy('akun_user.nama')
            ->select('dokter.*')
            ->get();

        $pasiens = Pasien::with('user')
            ->join('akun_user', 'pasien.id_user', '=', 'akun_user.id')
            ->orderBy('akun_user.nama')
            ->select('pasien.*')
            ->get();

        return view('admin.jadwal-edit', compact('jadwal', 'dokters', 'pasiens'));
    }

    // ─── Update ───────────────────────────────────────────────

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $validated = $request->validate([
            'id_dokter' => 'required|exists:dokter,id',
            'id_pasien' => 'nullable|exists:pasien,id',
            'tanggal'   => 'required|date',
            'jam'       => 'required|integer|min:0|max:23',
            'status'    => 'required|in:menunggu,dikonfirmasi,selesai,dibatalkan',
        ], [
            'id_dokter.required' => 'Dokter wajib dipilih.',
            'id_dokter.exists'   => 'Dokter tidak ditemukan.',
            'tanggal.required'   => 'Tanggal wajib diisi.',
            'tanggal.date'       => 'Format tanggal tidak valid.',
            'jam.required'       => 'Jam wajib dipilih.',
            'jam.integer'        => 'Jam tidak valid.',
            'status.required'    => 'Status wajib dipilih.',
            'status.in'          => 'Status tidak valid.',
        ]);

        // Cek konflik slot — kecuali jadwal itu sendiri
        $konflik = Jadwal::where('id_dokter', $validated['id_dokter'])
            ->where('tanggal', $validated['tanggal'])
            ->where('jam', $validated['jam'])
            ->where('id', '!=', $id)
            ->exists();

        if ($konflik) {
            return back()
                ->withInput()
                ->withErrors(['jam' => 'Slot jam tersebut sudah terisi untuk dokter dan tanggal yang dipilih.']);
        }

        $jadwal->update([
            'id_dokter' => $validated['id_dokter'],
            'id_pasien' => $validated['id_pasien'] ?: null,
            'tanggal'   => $validated['tanggal'],
            'jam'       => (int) $validated['jam'],
            'status'    => $validated['status'],
        ]);

        return redirect()->route('admin.jadwal.show', $id)
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    // ─── Destroy ──────────────────────────────────────────────

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        // Cegah hapus jadwal yang sudah selesai atau punya rekam medis
        if ($jadwal->status === 'selesai') {
            return back()->with('error', 'Jadwal yang sudah selesai tidak dapat dihapus.');
        }

        if ($jadwal->rekamMedis()->exists()) {
            return back()->with('error', 'Jadwal ini memiliki rekam medis terkait dan tidak dapat dihapus.');
        }

        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}