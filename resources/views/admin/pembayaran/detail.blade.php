@extends('admin.layouts.app')
@section('title', 'Detail Pembayaran')
@section('content')
<div class="space-y-6">


    {{-- Card utama --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex flex-wrap items-start justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Detail Pembayaran</h2>
                <p class="text-[14px] text-slate-500 mt-1">ID Pembayaran #{{ $pembayaran->id }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.pembayaran.edit', $pembayaran->id) }}"
                    class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.pembayaran.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">
                    Kembali
                </a>
            </div>
        </div>

        {{-- Badge status besar --}}
        <div class="mb-6">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-[13px] font-semibold {{ $pembayaran->status_badge }}">
                @if($pembayaran->status === 'lunas')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                @elseif($pembayaran->status === 'batal')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
                {{ $pembayaran->status_label }}
            </span>
        </div>

        {{-- Info Jadwal --}}
        <div class="mb-6 p-5 bg-slate-50 rounded-[16px] border border-slate-100">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Jadwal</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="space-y-1">
                    <p class="text-[12px] text-slate-500">Pasien</p>
                    <p class="text-[14px] font-semibold text-slate-800">{{ $pembayaran->jadwal->pasien?->user?->nama ?? '—' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[12px] text-slate-500">Dokter</p>
                    <p class="text-[14px] font-semibold text-slate-800">{{ $pembayaran->jadwal->dokter?->user?->nama ?? '—' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[12px] text-slate-500">Tanggal & Jam Kunjungan</p>
                    <p class="text-[14px] font-semibold text-slate-800">
                        {{ $pembayaran->jadwal->tanggal->translatedFormat('d M Y') }}
                        · {{ sprintf('%02d:00', $pembayaran->jadwal->jam) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Detail Pembayaran --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nomor Struk --}}
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Nomor Struk</p>
                <p class="text-[15px] font-semibold text-slate-800 font-mono">
                    {{ $pembayaran->nomor_struk ?? '—' }}
                </p>
            </div>

            {{-- Total Biaya --}}
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Biaya</p>
                <p class="text-[22px] font-bold text-slate-900">{{ $pembayaran->jumlah_format }}</p>
            </div>

            {{-- Metode --}}
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Metode Pembayaran</p>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[13px] font-semibold
                    {{ $pembayaran->metode === 'cash' ? 'bg-blue-50 text-blue-700' : ($pembayaran->metode === 'qris' ? 'bg-purple-50 text-purple-700' : 'bg-cyan-50 text-cyan-700') }}">
                    {{ $pembayaran->metode_label }}
                </span>
            </div>

            {{-- Tanggal Transaksi --}}
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tanggal Transaksi</p>
                <p class="text-[15px] font-semibold text-slate-800">
                    {{ $pembayaran->created_at ? \Carbon\Carbon::parse($pembayaran->created_at)->translatedFormat('d M Y, H:i') : '—' }}
                </p>
            </div>

            {{-- Terakhir diperbarui --}}
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Terakhir Diperbarui</p>
                <p class="text-[15px] font-semibold text-slate-800">
                    {{ $pembayaran->updated_at ? \Carbon\Carbon::parse($pembayaran->updated_at)->translatedFormat('d M Y, H:i') : '—' }}
                </p>
            </div>

            {{-- Pesan --}}
            @if($pembayaran->pesan)
            <div class="space-y-1 md:col-span-2 mt-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Pesan Tambahan</p>
                <p class="text-[14px] text-slate-700 bg-slate-50 p-4 rounded-xl border border-slate-100">{{ $pembayaran->pesan }}</p>
            </div>
            @endif

        </div>

        @if($pembayaran->metode === 'qris')
        {{-- Detail Integrasi QRIS Xendit --}}
        <div class="mt-8 pt-6 border-t border-slate-100">
            <h3 class="text-[14px] font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-qrcode text-purple-600"></i> Informasi QRIS (Xendit)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 bg-purple-50/50 p-6 rounded-2xl border border-purple-100/50">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-purple-400 uppercase tracking-widest">Xendit External ID</p>
                    <p class="text-[13px] font-mono text-purple-900">{{ $pembayaran->xendit_external_id ?? 'Belum digenerate' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-purple-400 uppercase tracking-widest">Xendit QR ID</p>
                    <p class="text-[13px] font-mono text-purple-900">{{ $pembayaran->xendit_qr_id ?? '—' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-purple-400 uppercase tracking-widest">Batas Waktu Pembayaran</p>
                    <p class="text-[13px] font-semibold text-purple-900">
                        {{ $pembayaran->payment_expired_at ? \Carbon\Carbon::parse($pembayaran->payment_expired_at)->translatedFormat('d M Y, H:i') : '—' }}
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-purple-400 uppercase tracking-widest">Status QR String</p>
                    <p class="text-[13px] font-semibold {{ $pembayaran->qr_string ? 'text-emerald-600' : 'text-slate-400' }}">
                        {{ $pembayaran->qr_string ? 'Tersedia (Ready to scan)' : 'Belum tersedia' }}
                    </p>
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- Rekam Medis terkait --}}
    @if($pembayaran->jadwal->rekamMedis)
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
            <h3 class="text-[16px] font-bold text-slate-800">Rekam Medis Terkait</h3>
            <a href="{{ route('admin.rekam-medis.show', $pembayaran->jadwal->rekamMedis->id) }}"
                class="text-[13px] text-slate-500 hover:text-slate-700 font-medium transition-colors">
                Lihat Lengkap →
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Keluhan</p>
                <p class="text-[14px] text-slate-700">{{ $pembayaran->jadwal->rekamMedis->keluhan ?? '—' }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Diagnosa</p>
                <p class="text-[14px] text-slate-700">{{ $pembayaran->jadwal->rekamMedis->diagnosa ?? '—' }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Catatan</p>
                <p class="text-[14px] text-slate-700">{{ $pembayaran->jadwal->rekamMedis->catatan ?? '—' }}</p>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
