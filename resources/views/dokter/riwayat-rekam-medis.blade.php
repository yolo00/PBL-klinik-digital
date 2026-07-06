@extends('dokter.layouts.dokter')
@section('title', 'Riwayat Rekam Medis')

@section('content')
@php
    \Carbon\Carbon::setLocale('id');
@endphp
{{-- Back + Title --}}
<div class="flex items-center gap-4 mb-7">
    <a href="{{ route('dokter.pasien') }}"
       class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
        <i class="fa-solid fa-arrow-left text-sm"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Rekam Medis</h1>
        <p class="text-slate-500 text-sm mt-0.5">
            Seluruh log rekam medis <span class="font-semibold text-blue-600">{{ $pasien->user->nama ?? 'Pasien' }}</span> di UniHealth.
        </p>
    </div>
</div>

{{-- Profil Pasien Card --}}
<div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl p-6 mb-6 flex flex-col md:flex-row justify-between gap-5 shadow-lg">
    <div class="space-y-3">
        <span class="px-3 py-1 bg-blue-500 text-white rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">
            Profil Pasien
        </span>
        <h2 class="text-xl font-bold text-white">{{ $pasien->user->nama ?? 'Nama Tidak Ditemukan' }}</h2>
        <div class="flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-300">
            <span><i class="fa-solid fa-venus-mars mr-1.5 text-purple-400"></i>
                {{ $pasien->user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
            </span>
            <span><i class="fa-solid fa-phone mr-1.5 text-blue-400"></i>{{ $pasien->user->no_hp ?? '-' }}</span>
            <span><i class="fa-solid fa-droplet mr-1.5 text-red-400"></i>Gol. Darah: {{ $pasien->gol_darah ?? '-' }}</span>
        </div>
    </div>
    <div class="flex items-center bg-white/10 border border-white/10 px-6 py-4 rounded-xl self-start md:self-center">
        <div class="text-center">
            <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Total Kunjungan</p>
            <p class="text-3xl font-bold text-blue-400 mt-0.5">
                {{ $rekamMedis->total() }}
                <span class="text-sm font-medium text-slate-400">Rekam</span>
            </p>
        </div>
    </div>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('dokter.rekam.riwayat', $pasien->id) }}" class="flex gap-2 mb-5">
    <div class="relative flex-1 max-w-sm">
        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
        <input type="text" name="search" value="{{ $search }}"
            placeholder="Cari diagnosa atau keluhan…"
            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all shadow-sm">
    </div>
    <button type="submit"
        class="px-4 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition-all shadow-sm">
        Cari
    </button>
    @if($search)
    <a href="{{ route('dokter.rekam.riwayat', $pasien->id) }}"
       class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-all">
        Reset
    </a>
    @endif
</form>

@if($search)
<div class="mb-4 text-sm text-slate-500">
    Hasil untuk <span class="font-semibold text-blue-600">"{{ $search }}"</span>
    — {{ $rekamMedis->total() }} ditemukan.
</div>
@endif

{{-- Tabel --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">ID Rekam</th>
                    <th class="text-left">Tanggal Kunjungan</th>
                    <th class="text-left">Diagnosa</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekamMedis as $rm)
                <tr>
                    <td class="text-slate-400 font-medium">#{{ $rm->id }}</td>
                    <td class="font-semibold text-slate-700">
                    {{ $rm->jadwal && $rm->jadwal->tanggal
                        ? \Carbon\Carbon::parse($rm->jadwal->tanggal)->translatedFormat('d F Y')
                        : '-' }}
                    </td>
                    <td class="text-slate-600 max-w-xs">
                        {{ \Illuminate\Support\Str::limit($rm->diagnosa ?? '-', 50) }}
                    </td>
                    <td>
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('dokter.rekam.show', $rm->id) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition-all">
                                <i class="fa-solid fa-eye text-[10px]"></i> Lihat
                            </a>
                            <a href="{{ route('dokter.rekam.export-pdf', $rm->id) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-all">
                                <i class="fa-solid fa-file-pdf text-[10px]"></i> PDF
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fa-solid fa-folder-open text-4xl text-slate-200"></i>
                            <p class="text-sm font-medium text-slate-400">
                                {{ $search ? 'Tidak ada rekam medis yang cocok.' : 'Belum ada riwayat rekam medis.' }}
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($rekamMedis->hasPages())
    <div class="px-6 py-4 border-t border-slate-50 flex items-center justify-between">
        <p class="text-xs text-slate-400">
            Menampilkan {{ $rekamMedis->firstItem() }} {{ $rekamMedis->lastItem() }} dari {{ $rekamMedis->total() }} rekam medis
        </p>
        <div class="flex items-center gap-1">
            @if($rekamMedis->onFirstPage())
                <span class="px-3 py-1.5 text-slate-300 bg-slate-50 rounded-lg text-xs font-semibold cursor-not-allowed border border-slate-100">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $rekamMedis->previousPageUrl() }}"
                   class="px-3 py-1.5 text-slate-600 bg-white rounded-lg text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition-all border border-slate-200">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            @foreach($rekamMedis->getUrlRange(1, $rekamMedis->lastPage()) as $page => $url)
                @if($page == $rekamMedis->currentPage())
                    <span class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1.5 text-slate-600 bg-white rounded-lg text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition-all border border-slate-200">{{ $page }}</a>
                @endif
            @endforeach

            @if($rekamMedis->hasMorePages())
                <a href="{{ $rekamMedis->nextPageUrl() }}"
                   class="px-3 py-1.5 text-slate-600 bg-white rounded-lg text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition-all border border-slate-200">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="px-3 py-1.5 text-slate-300 bg-slate-50 rounded-lg text-xs font-semibold cursor-not-allowed border border-slate-100">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
