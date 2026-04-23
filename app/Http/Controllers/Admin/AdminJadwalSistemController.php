<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CutiDokter;
use Illuminate\Http\Request;

class AdminJadwalSistemController extends Controller
{
    public function index()
    {
        $cutiDokters = CutiDokter::with('dokter.user')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.jadwal-sistem', compact('cutiDokters'));
    }

    public function approve($id)
    {
        $cuti = CutiDokter::findOrFail($id);
        $cuti->update(['status' => 'disetujui']);

        return back()->with('success', 'Cuti dokter berhasil disetujui.');
    }

    public function reject($id)
    {
        $cuti = CutiDokter::findOrFail($id);
        $cuti->update(['status' => 'ditolak']);

        return back()->with('success', 'Cuti dokter ditolak.');
    }

    public function show($id)
    {
        $cuti = CutiDokter::with('dokter.user')->findOrFail($id);

        return view('admin.cuti-dokter-detail', compact('cuti'));
    }
}
