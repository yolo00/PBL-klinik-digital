<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiPenerima;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * GET /notifikasi
     * Ambil daftar notifikasi milik user yang sedang login (JSON).
     * Dipakai oleh dropdown bell di header.
     */
    public function index(): JsonResponse
    {
        $userId = Auth::id();

        $items = NotifikasiPenerima::with('notifikasi')
            ->where('id_user', $userId)
            ->orderByDesc('id')           // notif terbaru dulu
            ->limit(20)
            ->get()
            ->map(fn($np) => [
                'id'         => $np->id,
                'type'       => $np->notifikasi->type,
                'message'    => $np->notifikasi->message,
                'ref_tabel'  => $np->notifikasi->ref_tabel,
                'ref_id'     => $np->notifikasi->ref_id,
                'is_urgent'  => $np->notifikasi->is_urgent,
                'is_seen'    => $np->is_seen,
                'created_at' => $np->notifikasi->created_at->diffForHumans(),
            ]);

        $unseenCount = NotifikasiPenerima::where('id_user', $userId)
            ->where('is_seen', 0)
            ->count();

        return response()->json([
            'items'        => $items,
            'unseen_count' => $unseenCount,
        ]);
    }

    /**
     * POST /notifikasi/mark-all-seen
     * Tandai semua notifikasi user sebagai sudah dibaca.
     */
    public function markAllSeen(): JsonResponse
    {
        $userId = Auth::id();

        NotifikasiPenerima::where('id_user', $userId)
            ->where('is_seen', 0)
            ->update([
                'is_seen'  => 1,
                'seen_at'  => now(),
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * GET /notifikasi/unseen-badge
     * Hanya kembalikan jumlah notif belum dibaca (untuk polling ringan).
     */
    public function unseenBadge(): JsonResponse
    {
        $userId = Auth::id();
        $count = NotifikasiPenerima::where('id_user', $userId)
            ->where('is_seen', 0)
            ->count();

        $user = Auth::user();
        
        // Data default untuk dots sidebar
        $hasJadwalBaru = false;
        $hasPengaturanDot = false;
        $hasJadwalPasienDot = false;
        $hasRekamMedisDot = false;

        if ($user) {
            // Untuk Dokter
            if ($user->role === 'D' && $user->dokter) {
                // Ada jadwal yang masih menunggu / dikonfirmasi
                $hasJadwalBaru = \App\Models\Jadwal::where('id_dokter', $user->dokter->id)
                    ->whereIn('status', ['menunggu', 'dikonfirmasi'])
                    ->exists();

                // Ada notifikasi cuti belum dibaca
                $hasPengaturanDot = NotifikasiPenerima::where('id_user', $userId)
                    ->where('is_seen', 0)
                    ->whereHas('notifikasi', function($q) {
                        $q->whereIn('type', ['Pengajuan Cuti Disetujui', 'Pengajuan Cuti Ditolak']);
                    })->exists();
            }
            
            // Untuk Pasien
            if ($user->role === 'P' && $user->pasien) {
                // Ada notifikasi jadwal batal otomatis / dibuat admin belum dibaca
                $hasJadwalPasienDot = NotifikasiPenerima::where('id_user', $userId)
                    ->where('is_seen', 0)
                    ->whereHas('notifikasi', function($q) {
                        $q->whereIn('type', ['Jadwal Tidak Ditangani', 'Jadwal Baru dari Admin']);
                    })->exists();

                // Ada notifikasi rekam medis baru belum dibaca
                $hasRekamMedisDot = NotifikasiPenerima::where('id_user', $userId)
                    ->where('is_seen', 0)
                    ->whereHas('notifikasi', function($q) {
                        $q->where('type', 'Rekam Medis Baru');
                    })->exists();
            }
        }

        return response()->json([
            'unseen_count'          => $count,
            'has_jadwal_baru'       => $hasJadwalBaru,
            'has_pengaturan_dot'    => $hasPengaturanDot,
            'has_jadwal_pasien_dot' => $hasJadwalPasienDot,
            'has_rekam_medis_dot'   => $hasRekamMedisDot,
        ]);
    }
}
