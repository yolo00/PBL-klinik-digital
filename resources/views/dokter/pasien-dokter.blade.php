@extends('dokter.layouts.dokter')
@section('title', 'Pasien Saya')

@section('content')
<div class="mb-7 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Pasien Saya</h1>
        <p class="text-slate-500 text-sm mt-1">Seluruh pasien yang pernah berkonsultasi dengan Anda.</p>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('dokter.pasien') }}" class="flex gap-2 w-full md:w-auto">
        <div class="relative flex-1 md:w-72">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Cari nama, email, no. telp…"
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all shadow-sm">
        </div>
        <button type="submit"
            class="px-4 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition-all shadow-sm">
            Cari
        </button>
        @if($search)
        <a href="{{ route('dokter.pasien') }}"
           class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-all">
            Reset
        </a>
        @endif
    </form>
</div>

{{-- Info hasil pencarian --}}
@if($search)
<div class="mb-4 text-sm text-slate-500">
    Menampilkan hasil pencarian untuk <span class="font-semibold text-blue-600">"{{ $search }}"</span>
    — {{ $pasiens->total() }} pasien ditemukan.
</div>
@endif

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">Nama Pasien</th>
                    <th class="text-left">Jenis Kelamin</th>
                    <th class="text-left">No. Telepon</th>
                    <th class="text-left">Gol. Darah</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pasiens as $pasien)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center shrink-0 border border-blue-100">
                                <i class="fa-solid fa-user text-blue-400 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $pasien->user->nama ?? '-' }}</p>
                                <p class="text-xs text-slate-400">{{ $pasien->user->email ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-slate-600">
                        {{ $pasien->user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>
                    <td class="text-slate-600">{{ $pasien->user->no_hp ?? '-' }}</td>
                    <td>
                        @if($pasien->gol_darah)
                            <span class="px-2.5 py-1 bg-red-50 text-red-500 rounded-lg text-xs font-bold border border-red-100">
                                {{ $pasien->gol_darah }}
                            </span>
                        @else
                            <span class="text-slate-300">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('dokter.rekam.riwayat', $pasien->id) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-all shadow-sm">
                            <i class="fa-solid fa-notes-medical text-[10px]"></i> Lihat Riwayat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-14 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fa-solid fa-user-slash text-4xl text-slate-200"></i>
                            <p class="text-sm font-medium text-slate-400">
                                {{ $search ? 'Tidak ada pasien yang cocok dengan pencarian.' : 'Belum ada pasien terdaftar.' }}
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($pasiens->hasPages())
    <div class="px-6 py-4 border-t border-slate-50 flex items-center justify-between">
        <p class="text-xs text-slate-400">
            Menampilkan {{ $pasiens->firstItem() }}–{{ $pasiens->lastItem() }} dari {{ $pasiens->total() }} pasien
        </p>
        <div class="flex items-center gap-1">
            {{-- Prev --}}
            @if($pasiens->onFirstPage())
                <span class="px-3 py-1.5 text-slate-300 bg-slate-50 rounded-lg text-xs font-semibold cursor-not-allowed border border-slate-100">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $pasiens->previousPageUrl() }}"
                   class="px-3 py-1.5 text-slate-600 bg-white rounded-lg text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition-all border border-slate-200">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach($pasiens->getUrlRange(1, $pasiens->lastPage()) as $page => $url)
                @if($page == $pasiens->currentPage())
                    <span class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1.5 text-slate-600 bg-white rounded-lg text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition-all border border-slate-200">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($pasiens->hasMorePages())
                <a href="{{ $pasiens->nextPageUrl() }}"
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
