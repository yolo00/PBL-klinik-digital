<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class XenditController extends Controller
{
    // ─── Xendit Sandbox base URL & key ────────────────────────
    private string $baseUrl = 'https://api.xendit.co';

    private function headers(): array
    {
        $secret = config('services.xendit.secret_key');
        return [
            'Authorization'  => 'Basic ' . base64_encode($secret . ':'),
            'Content-Type'   => 'application/json',
        ];
    }

    // =======================================================
    // 1. BUAT QR CODE — dipanggil saat pasien klik "Bayar QRIS"
    //    GET /pasien/pembayaran/{id}/qris
    // =======================================================
    public function showQris($pembayaran_id)
    {
        $pembayaran = Pembayaran::with('jadwal.dokter.user', 'jadwal.dokter.spesialisasi')
            ->findOrFail($pembayaran_id);

        // Keamanan: hanya pasien pemilik yang boleh akses
        $profilPasien = Auth::user()->pasien;
        if (!$profilPasien || $pembayaran->jadwal->id_pasien != $profilPasien->id) {
            return redirect()->route('pasien.riwayat')
                ->with('error', 'Akses ditolak.');
        }

        // Jika sudah lunas → redirect ke struk
        if ($pembayaran->status === 'lunas') {
            return redirect()->route('pasien.pembayaran.struk', $pembayaran->id);
        }

        // ── NEW: QRIS hanya bisa dibayar setelah jadwal selesai ──
        if ($pembayaran->jadwal->status !== 'selesai') {
            return redirect()->route('pasien.riwayat')
                ->with('error', 'Pembayaran QRIS hanya dapat dilakukan setelah jadwal pemeriksaan selesai.');
        }
        // ─────────────────────────────────────────────────────────

        // Jika QR belum dibuat atau sudah expired → buat baru
        $buatQrBaru = !$pembayaran->xendit_qr_id
            || !$pembayaran->payment_expired_at
            || Carbon::now()->gt($pembayaran->payment_expired_at);

        if ($buatQrBaru) {
            $hasil = $this->buatQrisXendit($pembayaran);
            if (!$hasil) {
                return redirect()->route('pasien.riwayat')
                    ->with('error', 'Gagal membuat QR Code. Coba lagi.');
            }
        }

        // Refresh data setelah kemungkinan update
        $pembayaran->refresh();

        return view('pasien.pembayaran-qris', compact('pembayaran'));
    }

    // =======================================================
    // 2. INTERNAL — Panggil Xendit API buat QR
    // =======================================================
    private function buatQrisXendit(Pembayaran $pembayaran): bool
    {
        $externalId  = 'KLINIK-' . $pembayaran->id . '-' . time();
        $expiredAt   = Carbon::now()->addMinutes(15); // 15 menit

        try {
            $response = Http::withHeaders($this->headers())
                ->timeout(15)
                ->post("{$this->baseUrl}/qr_codes", [
                    'external_id'     => $externalId,
                    'type'            => 'DYNAMIC',
                    'callback_url' => env('XENDIT_CALLBACK_URL'),
                    'amount'          => (int) $pembayaran->jumlah,
                    'currency'        => 'IDR',
                    'expires_at'      => $expiredAt->toIso8601String(),
                ]);

            if ($response->successful()) {
                $data = $response->json();

                $pembayaran->update([
                    'xendit_external_id' => $externalId,
                    'xendit_qr_id'       => $data['id'] ?? null,
                    'qr_string'          => $data['qr_string'] ?? null,
                    'payment_expired_at' => $expiredAt,
                    'metode'             => 'qris',
                ]);

                return true;
            }

            Log::error('Xendit QR Error', [
                'status'   => $response->status(),
                'body'     => $response->body(),
                'id_pembayaran' => $pembayaran->id,
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('Xendit Exception', [
                'message'       => $e->getMessage(),
                'id_pembayaran' => $pembayaran->id,
            ]);
            return false;
        }
    }

    // =======================================================
    // 3. WEBHOOK — Xendit POST ke sini saat pembayaran berhasil
    //    POST /xendit/callback  (tanpa auth middleware)
    // =======================================================
    public function callback(Request $request)
    {
        // Verifikasi Xendit callback token
        $callbackToken = config('services.xendit.callback_token');
        if (!empty($callbackToken)) {
            $receivedToken = $request->header('x-callback-token');
            if ($receivedToken !== $callbackToken) {
                Log::warning('Xendit callback token tidak valid');
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }

        $data   = $request->all();
        $event  = $data['event'] ?? null;
        Log::info('Xendit Callback', $data);

        // QR Paid event
        if ($event === 'qr.payment') {
            $externalId = $data['qr_code']['external_id'] ?? null;

            if (!$externalId) {
                return response()->json(['error' => 'external_id tidak ditemukan'], 400);
            }

            $pembayaran = Pembayaran::where('xendit_external_id', $externalId)->first();

            if ($pembayaran && $pembayaran->status !== 'lunas') {
                $nomorStruk = 'STR-' . now()->format('Ymd') . '-' . str_pad($pembayaran->id, 3, '0', STR_PAD_LEFT);

                $pembayaran->update([
                    'status'      => 'lunas',
                    'nomor_struk' => $nomorStruk,
                    'pesan'       => $data['payment_details']['source'] ?? null,
                ]);

                Log::info("Pembayaran ID {$pembayaran->id} berhasil via QRIS Xendit");
            }
        }

        return response()->json(['success' => true]);
    }

    // =======================================================
    // 4. POLLING — Frontend tanya status pembayaran (JSON)
    //    GET /pasien/pembayaran/{id}/status
    // =======================================================
    public function cekStatus($pembayaran_id)
    {
        $pembayaran   = Pembayaran::findOrFail($pembayaran_id);
        $profilPasien = Auth::user()->pasien;

        if (!$profilPasien || $pembayaran->jadwal->id_pasien != $profilPasien->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status'      => $pembayaran->status,
            'redirect_url'=> $pembayaran->status === 'lunas'
                ? route('pasien.pembayaran.struk', $pembayaran->id)
                : null,
        ]);
    }

    // =======================================================
    // 5. MANUAL CONFIRM — Fallback "Saya Sudah Bayar" (sandbox)
    //    POST /pasien/pembayaran/{id}/konfirmasi
    // =======================================================
    public function konfirmasiManual(Request $request, $pembayaran_id)
    {
        $pembayaran   = Pembayaran::findOrFail($pembayaran_id);
        $profilPasien = Auth::user()->pasien;

        if (!$profilPasien || $pembayaran->jadwal->id_pasien != $profilPasien->id) {
            return redirect()->route('pasien.riwayat')->with('error', 'Akses ditolak.');
        }

        if ($pembayaran->status === 'pending') {
            $nomorStruk = 'STR-' . now()->format('Ymd') . '-' . str_pad($pembayaran->id, 3, '0', STR_PAD_LEFT);

            $pembayaran->update([
                'status'      => 'lunas',
                'nomor_struk' => $nomorStruk,
                'pesan'       => 'Konfirmasi manual (sandbox)',
            ]);
        }

        return redirect()->route('pasien.pembayaran.struk', $pembayaran->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    // =======================================================
    // 6. STRUK — Halaman struk setelah lunas
    //    GET /pasien/pembayaran/{id}/struk
    // =======================================================
    public function struk($pembayaran_id)
    {
        $pembayaran   = Pembayaran::with('jadwal.dokter.user', 'jadwal.dokter.spesialisasi')
            ->findOrFail($pembayaran_id);
        $profilPasien = Auth::user()->pasien;

        if (!$profilPasien || $pembayaran->jadwal->id_pasien != $profilPasien->id) {
            return redirect()->route('pasien.riwayat')->with('error', 'Akses ditolak.');
        }

        return view('pasien.struk-pembayaran', compact('pembayaran'));
    }

    public function simulatePayment($pembayaran_id)
    {
        $pembayaran = Pembayaran::findOrFail($pembayaran_id);
        $profilPasien = Auth::user()->pasien;

        if (!$profilPasien || $pembayaran->jadwal->id_pasien != $profilPasien->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(config('services.xendit.secret_key') . ':'),
        ])->post("https://api.xendit.co/qr_codes/{$pembayaran->xendit_external_id}/payments/simulate", [
            'amount' => (int) $pembayaran->jumlah,
        ]);

        return response()->json($response->json());
    }
}