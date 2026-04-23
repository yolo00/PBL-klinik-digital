@extends('admin.layouts.app')
@section('title', 'Data Rekam Medis')
@section('content')
<div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="text-[20px] font-bold text-slate-800">Data Rekam Medis</h2>
        <a href="{{ route('admin.rekam-medis.create') }}" class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Data
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.rekam-medis.index') }}" class="flex flex-wrap gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pasien / dokter…"
            class="flex-1 min-w-[200px] max-w-[500px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all">
        <select name="sort" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[180px] appearance-none cursor-pointer">
            <option value="terbaru" {{ request('sort','terbaru') === 'terbaru' ? 'selected' : '' }}>Sortir : Terbaru</option>
            <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Sortir : Terlama</option>
        </select>
        <button type="submit" class="px-6 py-3 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm">Cari</button>
        <a href="{{ route('admin.rekam-medis.index') }}" class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">Reset</a>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">Id</th>
                    <th class="px-6 py-5">Nama Pasien</th>
                    <th class="px-6 py-5">Dokter Pemeriksa</th>
                    <th class="px-6 py-5">Tanggal</th>
                    <th class="px-6 py-5">Diagnosa</th>
                    <th class="px-6 py-5 text-center">Kelola</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                @forelse($rekamMedis as $rekam)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 align-middle text-slate-500">{{ $rekam->id_rekam }}</td>
                    <td class="px-6 py-5 align-middle">{{ $rekam->jadwal->pasien?->user?->nama ?? '—' }}</td>
                    <td class="px-6 py-5 align-middle">{{ $rekam->jadwal->dokter->dr_name }}</td>
                    <td class="px-6 py-5 align-middle">{{ $rekam->jadwal->tanggal->format('d M Y') }}</td>
                    <td class="px-6 py-5 align-middle text-slate-600">
                        {{ \Illuminate\Support\Str::limit($rekam->diagnosa ?? '—', 50) }}
                    </td>
                    <td class="px-6 py-5 text-center">
                        <x-admin.table-action
                            viewUrl="{{ route('admin.rekam-medis.show', $rekam->id_rekam) }}"
                            editUrl="{{ route('admin.rekam-medis.edit', $rekam->id_rekam) }}"
                        />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-400 text-[14px]">Belum ada data rekam medis.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-6 border-t border-gray-100 flex items-center justify-between gap-4 bg-gray-200/50 rounded-b-[24px]">
            <span class="text-[14px] text-slate-500">Menampilkan {{ $rekamMedis->firstItem() ?? 0 }} – {{ $rekamMedis->lastItem() ?? 0 }} dari {{ $rekamMedis->total() }} rekam medis</span>
            <div>{{ $rekamMedis->links() }}</div>
        </div>
    </div>
</div>
@endsection
