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
        $count = NotifikasiPenerima::where('id_user', Auth::id())
            ->where('is_seen', 0)
            ->count();

        // Tambahan: apakah ada jadwal BARU hari ini untuk dokter?
        // Dipakai untuk titik merah di sidebar "Jadwal Konsultasi"
        $hasJadwalBaru = false;
        $user = Auth::user();
        if ($user && $user->role === 'D' && $user->dokter) {
            $hasJadwalBaru = \App\Models\Jadwal::where('id_dokter', $user->dokter->id)
                ->whereDate('created_at', today())
                ->exists();
        }

        return response()->json([
            'unseen_count'    => $count,
            'has_jadwal_baru' => $hasJadwalBaru,
        ]);
    }
}
