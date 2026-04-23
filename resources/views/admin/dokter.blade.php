@extends('admin.layouts.app')
@section('title', 'Data Dokter')
@section('content')
<div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="text-[20px] font-bold text-slate-800">Data Dokter</h2>
        <a href="{{ route('admin.dokter.create') }}" class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Data
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.dokter.index') }}" class="flex flex-wrap gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / spesialis…"
            class="flex-1 min-w-[200px] max-w-[500px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all shadow-[0_2px_10px_rgb(0,0,0,0.02)]">

        <select name="sort" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[200px] appearance-none cursor-pointer">
            <option value="nama_asc"  {{ request('sort') === 'nama_asc'  ? 'selected' : '' }}>Sortir : Nama A – Z</option>
            <option value="nama_desc" {{ request('sort') === 'nama_desc' ? 'selected' : '' }}>Sortir : Nama Z – A</option>
        </select>

        <button type="submit" class="px-6 py-3 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm">Cari</button>
        <a href="{{ route('admin.dokter.index') }}" class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">Reset</a>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">Id</th>
                    <th class="px-6 py-5">Nama Dokter</th>
                    <th class="px-6 py-5">Spesialis</th>
                    <th class="px-6 py-5">Nomor HP</th>
                    <th class="px-6 py-5 text-center">Kelola</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                @forelse($dokters as $dokter)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 align-middle text-slate-500">{{ $dokter->id_dokter }}</td>
                    <td class="px-6 py-5 align-middle">{{ $dokter->user->nama ?? '-' }}</td>
                    <td class="px-6 py-5 align-middle">{{ $dokter->spesialis }}</td>
                    <td class="px-6 py-5 align-middle">{{ $dokter->user->no_hp ?? '-' }}</td>
                    <td class="px-6 py-5 text-center">
                        <x-admin.table-action
                            viewUrl="{{ route('admin.dokter.show', $dokter->id_dokter) }}"
                            editUrl="{{ route('admin.dokter.edit', $dokter->id_dokter) }}"
                        />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-[14px]">Belum ada data dokter.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="p-6 border-t border-gray-100 flex items-center justify-between gap-4 bg-gray-200/50 rounded-b-[24px]">
            <span class="text-[14px] text-slate-500">
                Menampilkan {{ $dokters->firstItem() ?? 0 }} – {{ $dokters->lastItem() ?? 0 }} dari {{ $dokters->total() }} dokter
            </span>
            <div class="text-[14px] font-bold text-slate-600">
                {{ $dokters->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
