@extends('admin.layouts.app')
@section('title', 'Data Jadwal')
@section('content')
<div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="text-[20px] font-bold text-slate-800">Data Jadwal Konsultasi</h2>
        <a href="{{ route('admin.jadwal.create') }}"
            class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Jadwal
        </a>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-[12px] text-[13px] text-emerald-700 flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 rounded-[12px] text-[13px] text-rose-700 flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.jadwal.index') }}" class="flex flex-wrap gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama pasien / dokter…"
            class="flex-1 min-w-[200px] max-w-[500px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all">
        <select name="status"
            class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[160px] appearance-none cursor-pointer">
            <option value="">Status : Semua</option>
            <option value="menunggu"     {{ request('status') === 'menunggu'     ? 'selected' : '' }}>Menunggu</option>
            <option value="dikonfirmasi" {{ request('status') === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="selesai"      {{ request('status') === 'selesai'      ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan"   {{ request('status') === 'dibatalkan'   ? 'selected' : '' }}>Dibatalkan</option>
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
        <a href="{{ route('admin.jadwal.index') }}"
            class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">
            Reset
        </a>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">ID</th>
                    <th class="px-6 py-5">Pasien</th>
                    <th class="px-6 py-5">Dokter</th>
                    <th class="px-6 py-5">Tanggal</th>
                    <th class="px-6 py-5">Jam</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-center">Kelola</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                @forelse($jadwals as $jadwal)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 align-middle text-slate-500 font-normal">#{{ $jadwal->id }}</td>
                    <td class="px-6 py-5 align-middle">
                        @if($jadwal->pasien?->user)
                            <div class="font-medium">{{ $jadwal->pasien->user->nama }}</div>
                            <div class="text-[12px] text-slate-400 font-normal">Pasien ID #{{ $jadwal->pasien->id }}</div>
                        @else
                            <span class="text-slate-400 font-normal">— Tanpa Pasien</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 align-middle">
                        <div class="font-medium">{{ $jadwal->dokter->user->nama ?? '—' }}</div>
                        <div class="text-[12px] text-slate-400 font-normal">
                            {{ $jadwal->dokter->spesialisasi->nama ?? '' }}
                        </div>
                    </td>
                    <td class="px-6 py-5 align-middle">{{ $jadwal->tanggal->translatedFormat('d M Y') }}</td>
                    <td class="px-6 py-5 align-middle font-mono">{{ $jadwal->jam_format }}</td>
                    <td class="px-6 py-5 align-middle">
                        <span class="px-2.5 py-1 rounded-full text-[12px] font-semibold {{ $jadwal->status_badge }}">
                            {{ $jadwal->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <x-admin.table-action
                            viewUrl="{{ route('admin.jadwal.show', $jadwal->id) }}"
                            editUrl="{{ route('admin.jadwal.edit', $jadwal->id) }}"
                        />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-14 text-center">
                        <div class="flex flex-col items-center gap-2 text-slate-400">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-[14px]">Belum ada data jadwal.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="p-6 border-t border-gray-100 flex items-center justify-between gap-4 bg-gray-200/50 rounded-b-[24px]">
            <span class="text-[14px] text-slate-500">
                Menampilkan {{ $jadwals->firstItem() ?? 0 }}–{{ $jadwals->lastItem() ?? 0 }}
                dari {{ $jadwals->total() }} jadwal
            </span>
            <div>{{ $jadwals->links() }}</div>
        </div>
    </div>
</div>
@endsection