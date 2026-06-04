<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use App\Models\JadwalSistem;
use Illuminate\Http\Request;

class AdminJadwalDokterController extends Controller
{
    public function edit(JadwalDokter $jadwalDokter)
    {
        $jadwalDokter->load('dokter.user');

        // Fetch Jadwal Sistem for this day
        $jadwalSistem = JadwalSistem::harian()->where('hari', $jadwalDokter->hari)->first();

        return view('admin.dokter.jadwal-edit', compact('jadwalDokter', 'jadwalSistem'));
    }

    public function update(Request $request, JadwalDokter $jadwalDokter)
    {
        $jadwalSistem = JadwalSistem::harian()->where('hari', $jadwalDokter->hari)->first();

        $maxBuka = $jadwalSistem && $jadwalSistem->jam_buka !== null ? $jadwalSistem->jam_buka : 0;
        $maxTutup = $jadwalSistem && $jadwalSistem->jam_tutup !== null ? $jadwalSistem->jam_tutup : 23;

        $request->validate([
            'jam_mulai' => "required|integer|min:$maxBuka|max:$maxTutup",
            'jam_selesai' => "required|integer|min:$maxBuka|max:$maxTutup|gte:jam_mulai",
            'override_istirahat_mulai' => "nullable|integer|min:$maxBuka|max:$maxTutup",
            'override_istirahat_selesai' => "nullable|integer|min:$maxBuka|max:$maxTutup|gt:override_istirahat_mulai",
            'is_aktif' => 'boolean',
        ], [
            'jam_selesai.gte' => 'Jam selesai harus lebih besar atau sama dengan jam mulai.',
            'override_istirahat_selesai.gt' => 'Jam istirahat selesai harus lebih besar dari jam mulai.',
            'jam_mulai.min' => "Jam mulai tidak boleh kurang dari jam operasional ($maxBuka:00).",
            'jam_selesai.max' => "Jam selesai tidak boleh lebih dari jam operasional ($maxTutup:00).",
        ]);

        $jadwalDokter->update([
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'override_istirahat_mulai' => $request->override_istirahat_mulai,
            'override_istirahat_selesai' => $request->override_istirahat_selesai,
            'is_aktif' => $request->boolean('is_aktif'),
        ]);

        return redirect()->route('admin.dokter.show', $jadwalDokter->id_dokter)
            ->with('success', 'Jadwal dokter hari ' . $jadwalDokter->hari . ' berhasil diperbarui.');
    }
}
