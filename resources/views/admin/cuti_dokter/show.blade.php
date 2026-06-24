@extends('admin.layouts.app')
@section('title', 'Detail Cuti Dokter')
@section('content')

<div class="space-y-6">

    {{-- Info utama --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">

        <div class="flex flex-wrap items-start justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Detail Pengajuan Cuti Dokter</h2>
                <p class="text-[14px] text-slate-500 mt-1">Diajukan pada {{ $cuti->created_at ? \Carbon\Carbon::parse($cuti->created_at)->translatedFormat('d F Y, H:i') : '—' }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                {{-- Tombol Setujui & Tolak hanya muncul kalau masih pending --}}
                @if($cuti->status === 'pending')
                <form action="{{ route('admin.cuti-dokter.approve', $cuti->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menyetujui pengajuan cuti ini?')">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2.5 bg-emerald-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-emerald-600 transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Setujui
                    </button>
                </form>
                <form action="{{ route('admin.cuti-dokter.reject', $cuti->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menolak pengajuan cuti ini?')">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2.5 bg-rose-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-rose-600 transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak
                    </button>
                </form>
                @else
                {{-- Badge status kalau sudah diproses --}}
                @php
                    $badge = match($cuti->status) {
                        'disetujui' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                        'ditolak'   => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                        default     => 'bg-slate-100 text-slate-600',
                    };
                @endphp
                <span class="inline-flex items-center px-4 py-2.5 rounded-[12px] text-[14px] font-semibold {{ $badge }}">
                    {{ $cuti->status_label }}
                </span>
                @endif

                <a href="{{ route('admin.cuti-dokter.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">
                    Kembali
                </a>
            </div>
        </div>

        {{-- Detail Dokter --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nama Dokter --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Nama Dokter</p>
                <p class="text-[15px] font-semibold text-slate-800">{{ $cuti->dokter->user->nama ?? '—' }}</p>
            </div>

            {{-- No Telepon --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">No. Telepon</p>
                <p class="text-[15px] font-semibold text-slate-800 font-mono">
                    {{ $cuti->dokter->user->no_hp ?? '—' }}
                </p>
            </div>

            {{-- Spesialisasi --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Spesialisasi</p>
                <p class="text-[15px] font-semibold text-slate-800">
                    {{ $cuti->dokter->spesialisasi->nama ?? '—' }}
                </p>
            </div>

            {{-- Dibuat --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Tanggal Pengajuan</p>
                <p class="text-[15px] font-semibold text-slate-800">
                    {{ $cuti->created_at ? \Carbon\Carbon::parse($cuti->created_at)->translatedFormat('l, d F Y · H:i') : '—' }}
                </p>
            </div>

            {{-- Dari Tanggal --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Dari Tanggal</p>
                <p class="text-[15px] font-semibold text-slate-800">
                    {{ $cuti->dari_tanggal->translatedFormat('l, d F Y') }}
                </p>
            </div>

            {{-- Sampai Tanggal --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Sampai Tanggal</p>
                <p class="text-[15px] font-semibold text-slate-800">
                    {{ $cuti->sampai_tanggal->translatedFormat('l, d F Y') }}
                </p>
            </div>

            {{-- Durasi --}}
            <div class="space-y-1 md:col-span-2">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Durasi Cuti</p>
                <p class="text-[15px] font-semibold text-slate-800">
                    {{ $cuti->dari_tanggal->diffInDays($cuti->sampai_tanggal) + 1 }} hari
                </p>
            </div>

        </div>
    </div>

    {{-- Alasan Cuti --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="mb-4 pb-4 border-b border-slate-100">
            <h3 class="text-[16px] font-bold text-slate-800">Alasan Pengajuan Cuti</h3>
        </div>
        <p class="text-[14px] text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $cuti->alasan ?? '—' }}</p>
    </div>

</div>
@endsection
