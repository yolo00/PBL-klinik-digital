@extends('dokter.layouts.dokter')
@section('title', 'Rekam Medis')

@section('content')

@php
    \Carbon\Carbon::setLocale('id');
@endphp

<div class="mb-7 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Rekam Medis</h1>
        <p class="text-slate-500 text-sm mt-1">Seluruh rekam medis pasien yang pernah Anda tangani.</p>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('dokter.rekam-medis') }}" class="flex gap-2 w-full md:w-auto">
        <div class="relative flex-1 md:w-72">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Cari nama pasien, diagnosa…"
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all shadow-sm">
        </div>
        <button type="submit"
            class="px-4 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition-all shadow-sm">
            Cari
        </button>
        @if($search)
        <a href="{{ route('dokter.rekam-medis') }}"
           class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-all">
            Reset
        </a>
        @endif
    </form>
</div>

@if($search)
<div class="mb-4 text-sm text-slate-500">
    Hasil pencarian untuk <span class="font-semibold text-blue-600">"{{ $search }}"</span>
    — {{ $rekamMedis->total() }} rekam medis ditemukan.
</div>
@endif

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">ID</th>
                    <th class="text-left">Nama Pasien</th>
                    <th class="text-left">Tanggal</th>
                    <th class="text-left">Diagnosa</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekamMedis as $rm)
                <tr>
                    <td class="text-slate-400 font-medium">#{{ $rm->id }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user text-blue-400 text-xs"></i>
                            </div>
                            <span class="font-semibold text-slate-800">
                                {{ $rm->jadwal->pasien->user->nama ?? 'Pasien Tidak Ditemukan' }}
                            </span>
                        </div>
                    </td>
                    <td class="text-slate-500 text-sm">
                    {{ $rm->jadwal && $rm->jadwal->tanggal
                        ? \Carbon\Carbon::parse($rm->jadwal->tanggal)->translatedFormat('d F Y')
                        : '-' }}
                    </td>
                    <td class="text-slate-600 max-w-xs">
                        {{ \Illuminate\Support\Str::limit($rm->diagnosa ?? '-', 50) }}
                    </td>
                    <td class="text-center">
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
                    <td colspan="5" class="py-14 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fa-solid fa-folder-open text-4xl text-slate-200"></i>
                            <p class="text-sm font-medium text-slate-400">
                                {{ $search ? 'Tidak ada rekam medis yang cocok.' : 'Belum ada rekam medis.' }}
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
            Menampilkan {{ $rekamMedis->firstItem() }}–{{ $rekamMedis->lastItem() }} dari {{ $rekamMedis->total() }} rekam medis
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
