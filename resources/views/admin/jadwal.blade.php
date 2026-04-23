@extends('admin.layouts.app')
@section('title', 'Data Jadwal')
@section('content')
<div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="text-[20px] font-bold text-slate-800">Data Jadwal Konsultasi</h2>
        <a href="{{ route('admin.jadwal.create') }}" class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Data
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.jadwal.index') }}" class="flex flex-wrap gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pasien / dokter…"
            class="flex-1 min-w-[200px] max-w-[500px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all">
        <select name="status" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[160px] appearance-none cursor-pointer">
            <option value="">Status : -</option>
            <option value="menunggu"     {{ request('status') === 'menunggu'     ? 'selected' : '' }}>Menunggu</option>
            <option value="dikonfirmasi" {{ request('status') === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="selesai"      {{ request('status') === 'selesai'      ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan"   {{ request('status') === 'dibatalkan'   ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <select name="sort" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[180px] appearance-none cursor-pointer">
            <option value="terbaru" {{ request('sort','terbaru') === 'terbaru' ? 'selected' : '' }}>Sortir : Terbaru</option>
            <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Sortir : Terlama</option>
        </select>
        <button type="submit" class="px-6 py-3 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm">Cari</button>
        <a href="{{ route('admin.jadwal.index') }}" class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">Reset</a>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">Id</th>
                    <th class="px-6 py-5">Nama Pasien</th>
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
                    <td class="px-6 py-5 align-middle text-slate-500">{{ $jadwal->id_jadwal }}</td>
                    <td class="px-6 py-5 align-middle">{{ $jadwal->pasien?->user?->nama ?? '—' }}</td>
                    <td class="px-6 py-5 align-middle">{{ $jadwal->dokter->dr_name }}</td>
                    <td class="px-6 py-5 align-middle">{{ $jadwal->tanggal->format('d M Y') }}</td>
                    <td class="px-6 py-5 align-middle">{{ \Illuminate\Support\Str::substr($jadwal->jam, 0, 5) }}</td>
                    <td class="px-6 py-5 align-middle font-bold {{ $jadwal->status_color }}">{{ $jadwal->status_label }}</td>
                    <td class="px-6 py-5 text-center">
                        <x-admin.table-action
                            viewUrl="{{ route('admin.jadwal.show', $jadwal->id_jadwal) }}"
                            editUrl="{{ route('admin.jadwal.edit', $jadwal->id_jadwal) }}"
                        />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-slate-400 text-[14px]">Belum ada data jadwal.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-6 border-t border-gray-100 flex items-center justify-between gap-4 bg-gray-200/50 rounded-b-[24px]">
            <span class="text-[14px] text-slate-500">Menampilkan {{ $jadwals->firstItem() ?? 0 }} – {{ $jadwals->lastItem() ?? 0 }} dari {{ $jadwals->total() }} jadwal</span>
            <div>{{ $jadwals->links() }}</div>
        </div>
    </div>
</div>
@endsection
