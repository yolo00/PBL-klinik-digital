@extends('admin.layouts.app')
@section('title', 'Data Pasien')
@section('content')
<div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="text-[20px] font-bold text-slate-800">Data Pasien</h2>
        <a href="{{ route('admin.pasien.create') }}" class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Data
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.pasien.index') }}" class="flex flex-wrap gap-4 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIM/NIK…"
            class="flex-1 min-w-[200px] max-w-[500px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all shadow-[0_2px_10px_rgb(0,0,0,0.02)]">

        <select name="jenis_kelamin" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[170px] appearance-none cursor-pointer">
            <option value="">Jenis Kelamin : -</option>
            <option value="L" {{ request('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ request('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>

        <select name="sort" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[200px] appearance-none cursor-pointer">
            <option value="nama_asc"  {{ request('sort') === 'nama_asc'  ? 'selected' : '' }}>Sortir : Nama A – Z</option>
            <option value="nama_desc" {{ request('sort') === 'nama_desc' ? 'selected' : '' }}>Sortir : Nama Z – A</option>
            <option value="terbaru"   {{ request('sort') === 'terbaru'   ? 'selected' : '' }}>Sortir : Terbaru</option>
        </select>

        <button type="submit" class="px-6 py-3 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm">Cari</button>
        <a href="{{ route('admin.pasien.index') }}" class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">Reset</a>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">Id</th>
                    <th class="px-6 py-5">Nama</th>
                    <th class="px-6 py-5">NIM / NIK</th>
                    <th class="px-6 py-5">Nomor HP</th>
                    <th class="px-6 py-5">Jenis Kelamin</th>
                    <th class="px-6 py-5 text-center">Kelola</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                @forelse($pasiens as $pasien)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 align-middle text-slate-500">{{ $pasien->id_pasien }}</td>
                    <td class="px-6 py-5 align-middle">{{ $pasien->user->nama ?? '-' }}</td>
                    <td class="px-6 py-5 align-middle">{{ $pasien->nimnik }}</td>
                    <td class="px-6 py-5 align-middle">{{ $pasien->user->no_hp ?? '-' }}</td>
                    <td class="px-6 py-5 align-middle">{{ $pasien->user->jenis_kelamin_label ?? '-' }}</td>
                    <td class="px-6 py-5 text-center">
                        <x-admin.table-action
                            viewUrl="{{ route('admin.pasien.show', $pasien->id_pasien) }}"
                            editUrl="{{ route('admin.pasien.edit', $pasien->id_pasien) }}"
                        />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-400 text-[14px]">Belum ada data pasien.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="p-6 border-t border-gray-100 flex items-center justify-between gap-4 bg-gray-200/50 rounded-b-[24px]">
            <span class="text-[14px] text-slate-500">
                Menampilkan {{ $pasiens->firstItem() ?? 0 }} – {{ $pasiens->lastItem() ?? 0 }} dari {{ $pasiens->total() }} pasien
            </span>
            <div class="text-[14px] font-bold text-slate-600">
                {{ $pasiens->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
