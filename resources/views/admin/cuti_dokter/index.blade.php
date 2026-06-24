@extends('admin.layouts.app')
@section('title', 'Manajemen Cuti Dokter')
@section('content')
<div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="text-[20px] font-bold text-slate-800">Manajemen Cuti Dokter</h2>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.cuti-dokter.index') }}" class="flex flex-wrap gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama dokter…"
            class="flex-1 min-w-[200px] max-w-[500px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all">
        <select name="status"
            class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[180px] appearance-none cursor-pointer">
            <option value="">Status : Semua</option>
            <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
            <option value="disetujui"  {{ request('status') === 'disetujui'  ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak"    {{ request('status') === 'ditolak'    ? 'selected' : '' }}>Ditolak</option>
        </select>
        <select name="sort"
            class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[180px] appearance-none cursor-pointer">
            <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Sortir : Terbaru</option>
            <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Sortir : Terlama</option>
        </select>
        <button type="submit"
            class="px-6 py-3 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm">
            Cari
        </button>
        <a href="{{ route('admin.cuti-dokter.index') }}"
            class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">
            Reset
        </a>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">Nama Dokter</th>
                    <th class="px-6 py-5">Periode Cuti</th>
                    <th class="px-6 py-5">Alasan</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                @forelse($cutis as $cuti)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 align-middle">
                        <div class="font-medium">{{ $cuti->dokter->user->nama ?? '—' }}</div>
                        <div class="text-[12px] text-slate-400 font-normal">
                            {{ $cuti->dokter->spesialisasi->nama ?? '' }}
                        </div>
                    </td>
                    <td class="px-6 py-5 align-middle font-normal">
                        <span class="font-medium">{{ $cuti->dari_tanggal->translatedFormat('d M Y') }}</span>
                        <span class="text-slate-400 mx-1">–</span>
                        <span class="font-medium">{{ $cuti->sampai_tanggal->translatedFormat('d M Y') }}</span>
                    </td>
                    <td class="px-6 py-5 align-middle font-normal text-slate-600 max-w-[260px]">
                        <p class="line-clamp-2">{{ $cuti->alasan ?? '—' }}</p>
                    </td>
                    <td class="px-6 py-5 align-middle">
                        @php
                            $badge = match($cuti->status) {
                                'pending'   => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                'disetujui' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                'ditolak'   => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                                default     => 'bg-slate-100 text-slate-600',
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-[12px] font-semibold {{ $badge }}">
                            {{ $cuti->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <x-admin.table-action
                            viewUrl="{{ route('admin.cuti-dokter.show', $cuti->id) }}"
                            deleteUrl="{{ route('admin.cuti-dokter.destroy', $cuti->id) }}"
                        />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-14 text-center">
                        <div class="flex flex-col items-center gap-2 text-slate-400">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-[14px]">Belum ada data pengajuan cuti.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="p-6 border-t border-gray-100 flex items-center justify-between gap-4 bg-gray-200/50 rounded-b-[24px]">
            <span class="text-[14px] text-slate-500">
                Menampilkan {{ $cutis->firstItem() ?? 0 }}–{{ $cutis->lastItem() ?? 0 }}
                dari {{ $cutis->total() }} pengajuan
            </span>
            <div>{{ $cutis->links() }}</div>
        </div>
    </div>
</div>
@endsection
