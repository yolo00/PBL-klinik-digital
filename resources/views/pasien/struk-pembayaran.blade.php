@extends('pasien.layouts.app')
@section('title', 'Struk Pembayaran')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('pasien.riwayat') }}" class="text-slate-400 hover:text-slate-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Struk Pembayaran</h3>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-medium">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-[2rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden" id="struk-area">

        {{-- Status badge --}}
        <div class="absolute top-8 right-8">
            @if($pembayaran->status === 'lunas')
                <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-emerald-100">
                    ✓ Lunas
                </span>
            @elseif($pembayaran->status === 'pending')
                <span class="px-4 py-1.5 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-amber-100">
                    Pending
                </span>
            @else
                <span class="px-4 py-1.5 bg-red-50 text-red-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-red-100">
                    Batal
                </span>
            @endif
        </div>

        <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-8">Struk Pembayaran</p>

        {{-- Nominal & Nomor Struk --}}
        <div class="bg-slate-50 rounded-3xl p-8 mb-6 border border-slate-100">
            <div class="mb-5">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nominal</p>
                <h4 class="text-3xl font-black text-slate-900">
                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                </h4>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @if($pembayaran->nomor_struk)
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nomor Struk</p>
                    <p class="text-sm font-mono font-bold text-slate-700">{{ $pembayaran->nomor_struk }}</p>
                </div>
                @endif

                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Metode Pembayaran</p>
                    <p class="text-sm font-bold text-slate-700 uppercase">
                        {{ $pembayaran->metode === 'qris' ? 'QRIS' : 'Cash' }}
                    </p>
                </div>

                @if($pembayaran->pesan)
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Keterangan</p>
                    <p class="text-xs font-mono text-slate-600 break-all">{{ $pembayaran->pesan }}</p>
                </div>
                @endif

                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu Pembayaran</p>
                    <p class="text-xs font-bold text-slate-700">
                        {{ $pembayaran->updated_at
                            ? \Carbon\Carbon::parse($pembayaran->updated_at)->locale('id')->translatedFormat('d F Y, H:i') . ' WIB'
                            : '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Informasi Jadwal --}}
        <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Informasi Jadwal</p>

            <div class="flex flex-col gap-5">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Tanggal dan Sesi</p>
                    <p class="text-sm font-bold text-slate-800">
                        {{ \Carbon\Carbon::parse($pembayaran->jadwal->tanggal)->locale('id')->translatedFormat('d F Y') }}
                        &bull; {{ $pembayaran->jadwal->jam }}:00 WIB
                    </p>
                </div>

                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Dokter</p>
                    <p class="text-sm font-bold text-slate-800">
                        {{ $pembayaran->jadwal->dokter->user->nama ?? '-' }}
                    </p>
                    @if($pembayaran->jadwal->dokter && $pembayaran->jadwal->dokter->spesialisasi)
                    <p class="text-xs text-slate-400">{{ $pembayaran->jadwal->dokter->spesialisasi->nama }}</p>
                    @endif
                </div>

                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Pasien</p>
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->nama }}</p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex gap-3">
            <a href="{{ route('pasien.riwayat') }}"
               class="flex-1 flex items-center justify-center gap-2 py-4 border-2 border-slate-200 rounded-2xl text-slate-500 font-bold text-xs hover:bg-slate-50 transition uppercase tracking-widest">
                ← Riwayat Jadwal
            </a>
            <button onclick="window.print()"
                class="flex-1 flex items-center justify-center gap-2 py-4 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400 font-bold text-xs hover:bg-slate-50 transition uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Cetak Struk
            </button>
        </div>
    </div>
</div>

@push('scripts')
<style>
    @media print {
        aside, header, a, button { display: none !important; }
        body { background: white !important; }
        #struk-area { box-shadow: none !important; border: none !important; }
    }
</style>
@endpush
@endsection