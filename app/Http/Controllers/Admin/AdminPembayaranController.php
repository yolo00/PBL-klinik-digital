<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class AdminPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('jadwal.pasien.user', 'jadwal.dokter.user');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nomor struk / nama pasien
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_struk', 'like', "%{$search}%")
                  ->orWhereHas('jadwal.pasien.user', fn($sq) => $sq->where('nama', 'like', "%{$search}%"));
            });
        }

        // Sortir
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'terlama' => $query->orderBy('created_at', 'asc'),
            default   => $query->orderByDesc('created_at'),
        };

        $pembayarans = $query->paginate(10)->withQueryString();

        return view('admin.pembayaran', compact('pembayarans'));
    }

    public function create()
    {
        // Tampilkan jadwal yang belum punya pembayaran
        $jadwals = Jadwal::with('dokter.user', 'pasien.user')
            ->whereDoesntHave('pembayaran')
            ->whereNotNull('id_pasien')
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.pembayaran-create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal'   => 'required|exists:jadwal,id_jadwal|unique:pembayaran,id_jadwal',
            'jumlah'      => 'required|numeric|min:0',
            'metode'      => 'required|in:cash,qris',
            'status'      => 'required|in:pending,lunas,batal',
            'nomor_struk' => 'nullable|string|max:50',
        ], [
            'id_jadwal.required' => 'Jadwal wajib dipilih.',
            'id_jadwal.unique'   => 'Pembayaran untuk jadwal ini sudah ada.',
            'jumlah.required'    => 'Jumlah wajib diisi.',
            'metode.required'    => 'Metode pembayaran wajib dipilih.',
            'status.required'    => 'Status wajib dipilih.',
        ]);

        Pembayaran::create([
            'id_jadwal'   => $request->id_jadwal,
            'jumlah'      => $request->jumlah,
            'metode'      => $request->metode,
            'status'      => $request->status,
            'nomor_struk' => $request->nomor_struk,
        ]);

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Data pembayaran berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with(
            'jadwal.pasien.user',
            'jadwal.dokter.user',
            'jadwal.rekamMedis'
        )->findOrFail($id);

        return view('admin.pembayaran-detail', compact('pembayaran'));
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::with('jadwal.pasien.user', 'jadwal.dokter.user')
            ->findOrFail($id);

        $jadwals = Jadwal::with('dokter.user', 'pasien.user')
            ->where(function ($q) use ($pembayaran) {
                $q->whereDoesntHave('pembayaran')
                  ->orWhere('id_jadwal', $pembayaran->id_jadwal);
            })
            ->whereNotNull('id_pasien')
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.pembayaran-edit', compact('pembayaran', 'jadwals'));
    }
}
