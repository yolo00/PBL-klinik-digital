<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Models\Notifikasi;
use App\Models\AkunUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AutoStatusController extends Controller
{
    /**
     * Memeriksa dan memperbarui status jadwal secara otomatis.
     * Dapat dipanggil melalui route/cron/scheduler.
     */
    public function updateStatus()
    {
        // Ambil jadwal yang statusnya menunggu atau dikonfirmasi
        $jadwals = Jadwal::with(['pasien.user', 'dokter.user', 'pembayaran'])->whereIn('status', ['menunggu', 'dikonfirmasi'])->get();
        $now = Carbon::now('Asia/Jakarta');

        $updatedCount = 0;

        foreach ($jadwals as $jadwal) {
            // Tentukan waktu jadwal berdasarkan tanggal dan jam yang dipilih
            $scheduledTime = Carbon::parse($jadwal->tanggal)->setTime($jadwal->jam, 0, 0);
            
            // 1. Bila status jadwal masih mendatang (menunggu)
            if ($jadwal->status === 'menunggu') {
                // Jika tanggal dan waktu jadwal melewati 90 menit dari waktu jadwal
                if ($now->greaterThan($scheduledTime->copy()->addMinutes(90))) {
                    $jadwal->update(['status' => 'dibatalkan']);
                    
                    Pembayaran::where('id_jadwal', $jadwal->id)
                        ->where('status', 'pending')
                        ->update(['status' => 'batal']);
                        
                    $updatedCount++;

                    // ── NOTIFIKASI AUTO-BATAL ───────────────────────────────────────
                    $namaPasien = $jadwal->pasien->user->nama ?? 'Pasien';
                    $namaDokter = $jadwal->dokter->user->nama ?? 'Dokter';
                    $jamStr     = sprintf('%02d:00', $jadwal->jam);
                    $tglStr     = \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y');
                    
                    // 1. Notif ke Pasien
                    if ($jadwal->pasien && $jadwal->pasien->id_user) {
                        Notifikasi::kirim([
                            'type'       => 'Jadwal Tidak Ditangani',
                            'message'    => "Jadwal Anda pada {$jamStr}, {$tglStr} dengan Dr. {$namaDokter} tidak ditangani. Silakan buat jadwal baru.",
                            'ref_tabel'  => 'jadwal',
                            'ref_id'     => $jadwal->id,
                            'is_urgent'  => 0,
                            'created_by' => null, // Sistem
                        ], $jadwal->pasien->id_user);
                    }
                    
                    // 2. Notif ke Dokter
                    if ($jadwal->dokter && $jadwal->dokter->id_user) {
                        Notifikasi::kirim([
                            'type'       => 'Jadwal Terlewatkan',
                            'message'    => "Jadwal {$namaPasien} pada {$jamStr}, {$tglStr} telah terlewatkan.",
                            'ref_tabel'  => 'jadwal',
                            'ref_id'     => $jadwal->id,
                            'is_urgent'  => 0,
                            'created_by' => null,
                        ], $jadwal->dokter->id_user);
                    }
                    
                    // 3. Notif ke Semua Admin
                    $adminIds = AkunUser::where('role', 'A')->whereNull('deleted_at')->pluck('id')->toArray();
                    if (!empty($adminIds)) {
                        Notifikasi::kirim([
                            'type'       => 'Jadwal Tidak Ditangani',
                            'message'    => "Jadwal {$namaPasien} dengan Dr. {$namaDokter} pada {$jamStr}, {$tglStr} tidak ditangani dan dibatalkan otomatis.",
                            'ref_tabel'  => 'jadwal',
                            'ref_id'     => $jadwal->id,
                            'is_urgent'  => 0,
                            'created_by' => null,
                        ], $adminIds);
                    }
                    // ────────────────────────────────────────────────────────────────
                }
            } 
            // 2. Bila status jadwal sudah dikonfirmasi
            elseif ($jadwal->status === 'dikonfirmasi') {
                // Jika tanggal dan waktu jadwal sudah melewati 1 jam (90 menit)
                if ($now->greaterThan($scheduledTime->copy()->addMinutes(90))) {
                    $jadwal->update(['status' => 'selesai']);
                    $updatedCount++;

                    // ── NOTIFIKASI: jika auto-selesai & bayar cash pending → notif ke admin ──
                    if ($jadwal->pembayaran
                        && $jadwal->pembayaran->metode === 'cash'
                        && $jadwal->pembayaran->status === 'pending'
                    ) {
                        $adminIds = AkunUser::where('role', 'A')->whereNull('deleted_at')->pluck('id')->toArray();
                        $namaPasien = $jadwal->pasien->user->nama ?? 'Pasien';
                        $namaDokter = $jadwal->dokter->user->nama ?? 'Dokter';

                        if (!empty($adminIds)) {
                            Notifikasi::kirim([
                                'type'       => 'Konfirmasi Pembayaran Cash',
                                'message'    => "Jadwal {$namaPasien} dengan Dr. {$namaDokter} telah selesai secara otomatis. Metode pembayaran: Cash. Mohon konfirmasi pembayaran.",
                                'ref_tabel'  => 'pembayaran',
                                'ref_id'     => $jadwal->pembayaran->id,
                                'is_urgent'  => 0,
                                'created_by' => null, // Sistem
                            ], $adminIds);
                        }
                    }
                    // ───────────────────────────────────────────────────────────────────────
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Status jadwal otomatis berhasil diperbarui.',
            'updated_count' => $updatedCount
        ]);
    }
}
