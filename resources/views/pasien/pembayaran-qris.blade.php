@extends('pasien.layouts.app')
@section('title', 'Pembayaran QRIS')
@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('pasien.riwayat') }}" class="text-slate-400 hover:text-slate-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Pembayaran QRIS</h3>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-medium">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- ── Kolom Kiri: QR Code ──────────────────────────── --}}
        <div class="md:col-span-2 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col items-center">

            <p class="text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider text-center">
                Pindai kode QR ini untuk melakukan pembayaran
            </p>
            <p class="text-xs text-slate-400 mb-6 text-center">Gunakan aplikasi mobile banking atau e-wallet apapun yang mendukung QRIS</p>

            {{-- QR Code area --}}
            <div class="bg-white p-4 rounded-2xl border-2 border-dashed border-slate-200 mb-6 shadow-inner" id="qr-wrapper">
                @if($pembayaran->qr_string)
                    {{-- Render QR dari qr_string via QR API --}}
                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($pembayaran->qr_string) }}"
                        alt="QR Code Pembayaran"
                        class="w-56 h-56"
                        id="qr-img"
                    >
                @else
                    <div class="w-56 h-56 flex items-center justify-center bg-slate-100 rounded-xl text-slate-400 text-sm">
                        QR tidak tersedia
                    </div>
                @endif
            </div>

            {{-- Status badge --}}
            <div id="status-badge" class="mb-4">
                @if($pembayaran->status === 'pending')
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 text-amber-700 text-sm font-bold border border-amber-200">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse inline-block"></span>
                    Menunggu Pembayaran
                </span>
                @else
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 text-sm font-bold border border-emerald-200">
                    ✓ Pembayaran Diterima
                </span>
                @endif
            </div>

            {{-- Butuh bantuan --}}
            <div class="w-full bg-blue-50 rounded-2xl p-5 border border-blue-100 mt-2">
                <p class="text-xs font-bold text-blue-800 mb-2 uppercase tracking-widest text-center">Butuh Bantuan?</p>
                <div class="flex flex-col gap-1 text-center">
                    <span class="text-sm font-bold text-blue-800">WhatsApp: 0871-2345-6789</span>
                    <span class="text-sm font-bold text-blue-800">Email: health67@gmail.com</span>
                </div>
            </div>
        </div>

        {{-- ── Kolom Kanan: Info & Aksi ─────────────────────── --}}
        <div class="flex flex-col gap-6">

            {{-- Nominal & Kode --}}
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nominal</p>
                <h4 class="text-2xl font-black text-slate-900 mb-4">
                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                </h4>

                @if($pembayaran->qr_string)
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kode QR</p>
                <p class="text-[10px] font-mono text-slate-500 mb-4 break-all leading-relaxed">
                    {{ Str::limit($pembayaran->qr_string, 60) }}
                </p>
                @endif

                {{-- Countdown --}}
                <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-500">Sisa Waktu</p>
                    <p class="text-sm font-black text-red-500" id="countdown">--:--</p>
                </div>
            </div>

            {{-- Informasi Jadwal --}}
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Jadwal</p>

                <div class="mb-4">
                    <p class="text-[10px] font-bold text-slate-500 uppercase">Tanggal & Sesi</p>
                    <p class="text-sm font-bold text-slate-800">
                        {{ \Carbon\Carbon::parse($pembayaran->jadwal->tanggal)->locale('id')->translatedFormat('d F Y') }}
                        &bull; {{ $pembayaran->jadwal->jam }}:00 WIB
                    </p>
                </div>

                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase">Dokter</p>
                    <p class="text-sm font-bold text-slate-800">
                        {{ $pembayaran->jadwal->dokter->user->nama ?? '-' }}
                    </p>
                    @if($pembayaran->jadwal->dokter && $pembayaran->jadwal->dokter->spesialisasi)
                    <p class="text-xs text-slate-400">
                        {{ $pembayaran->jadwal->dokter->spesialisasi->nama }}
                    </p>
                    @endif
                </div>
            </div>

            {{-- Tombol Manual Confirm (sandbox fallback) --}}
            @if($pembayaran->status === 'pending')
            <form action="{{ route('pasien.pembayaran.konfirmasi', $pembayaran->id) }}" method="POST"
                  onsubmit="return confirm('Konfirmasi bahwa Anda sudah melakukan pembayaran?')">
                @csrf
                <button type="submit"
                    class="w-full bg-emerald-500 hover:bg-emerald-600 py-4 rounded-2xl text-white font-bold text-sm shadow-lg shadow-emerald-100 transition duration-300 transform hover:-translate-y-1">
                    ✅ SAYA SUDAH BAYAR
                </button>
            </form>
            <p class="text-[10px] text-slate-400 text-center -mt-3">
                Gunakan tombol ini jika pembayaran Anda tidak terdeteksi otomatis
            </p>
            @else
            <a href="{{ route('pasien.pembayaran.struk', $pembayaran->id) }}"
               class="w-full bg-emerald-500 hover:bg-emerald-600 py-4 rounded-2xl text-white font-bold text-sm shadow-lg shadow-emerald-100 transition text-center block">
                Lihat Struk Pembayaran →
            </a>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
    const pembayaranId = {{ $pembayaran->id }};
    const statusAwal   = "{{ $pembayaran->status }}";
    const expiredAt    = "{{ $pembayaran->payment_expired_at ? $pembayaran->payment_expired_at->toIso8601String() : '' }}";
    const statusUrl    = "{{ route('pasien.pembayaran.status', $pembayaran->id) }}";

    // ─── Countdown timer ─────────────────────────────────────
    function startCountdown() {
        if (!expiredAt) return;

        const expiry = new Date(expiredAt).getTime();
        const el     = document.getElementById('countdown');

        const tick = () => {
            const now  = Date.now();
            const diff = expiry - now;

            if (diff <= 0) {
                el.textContent = '00:00';
                el.closest('.flex').classList.add('bg-red-50');
                return;
            }

            const m = Math.floor(diff / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            el.textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;

            // Warna merah saat < 3 menit
            if (diff < 180000) el.classList.add('text-red-600');

            setTimeout(tick, 1000);
        };
        tick();
    }

    // ─── Polling status setiap 5 detik ───────────────────────
    function startPolling() {
        if (statusAwal !== 'pending') return;

        const interval = setInterval(async () => {
            try {
                const res  = await fetch(statusUrl);
                const data = await res.json();

                if (data.status === 'lunas') {
                    clearInterval(interval);

                    // Update badge
                    document.getElementById('status-badge').innerHTML = `
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 text-sm font-bold border border-emerald-200">
                            ✓ Pembayaran Diterima!
                        </span>`;

                    // Redirect ke struk setelah 1.5 detik
                    setTimeout(() => {
                        if (data.redirect_url) window.location.href = data.redirect_url;
                    }, 1500);
                }
            } catch (e) {
                // silent fail — polling tetap jalan
            }
        }, 5000);
    }

    startCountdown();
    startPolling();
</script>
@endpush
@endsection