<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pembayaran;
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
        $jadwals = Jadwal::whereIn('status', ['menunggu', 'dikonfirmasi'])->get();
        $now = Carbon::now('Asia/Jakarta');

        $updatedCount = 0;

        foreach ($jadwals as $jadwal) {
            // Tentukan waktu jadwal berdasarkan tanggal dan jam yang dipilih
            $scheduledTime = Carbon::parse($jadwal->tanggal)->setTime($jadwal->jam, 0, 0);
            
            // 1. Bila status jadwal masih mendatang (menunggu)
            if ($jadwal->status === 'menunggu') {
                // Jika tanggal dan waktu jadwal melewati 30 menit dari waktu jadwal
                if ($now->greaterThan($scheduledTime->copy()->addMinutes(30))) {
                    $jadwal->update(['status' => 'dibatalkan']);
                    
                    Pembayaran::where('id_jadwal', $jadwal->id)
                        ->where('status', 'pending')
                        ->update(['status' => 'batal']);
                        
                    $updatedCount++;
                }
            } 
            // 2. Bila status jadwal sudah dikonfirmasi
            elseif ($jadwal->status === 'dikonfirmasi') {
                // Jika tanggal dan waktu jadwal sudah melewati 1 jam
                if ($now->greaterThan($scheduledTime->copy()->addHours(1))) {
                    $jadwal->update(['status' => 'selesai']);
                    $updatedCount++;
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
