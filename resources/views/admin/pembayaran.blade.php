@extends('admin.layouts.app')
@section('title', 'Data Pembayaran')
@section('content')
<div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="text-[20px] font-bold text-slate-800">Data Pembayaran</h2>
        <a href="{{ route('admin.pembayaran.create') }}" class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Data
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex flex-wrap gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. struk / nama pasien…"
            class="flex-1 min-w-[200px] max-w-[500px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all">
        <select name="status" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[160px] appearance-none cursor-pointer">
            <option value="">Status : -</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="lunas"   {{ request('status') === 'lunas'   ? 'selected' : '' }}>Lunas</option>
            <option value="batal"   {{ request('status') === 'batal'   ? 'selected' : '' }}>Batal</option>
        </select>
        <select name="sort" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[180px] appearance-none cursor-pointer">
            <option value="terbaru" {{ request('sort','terbaru') === 'terbaru' ? 'selected' : '' }}>Sortir : Terbaru</option>
            <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Sortir : Terlama</option>
        </select>
        <button type="submit" class="px-6 py-3 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm">Cari</button>
        <a href="{{ route('admin.pembayaran.index') }}" class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">Reset</a>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">Id</th>
                    <th class="px-6 py-5">Nomor Struk</th>
                    <th class="px-6 py-5">Pasien</th>
                    <th class="px-6 py-5">Metode</th>
                    <th class="px-6 py-5">Total Biaya</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-center">Kelola</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                @forelse($pembayarans as $bayar)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 align-middle text-slate-500">{{ $bayar->id_pembayaran }}</td>
                    <td class="px-6 py-5 align-middle text-slate-700">{{ $bayar->nomor_struk ?? '—' }}</td>
                    <td class="px-6 py-5 align-middle">{{ $bayar->jadwal->pasien?->user?->nama ?? '—' }}</td>
                    <td class="px-6 py-5 align-middle uppercase">{{ $bayar->metode }}</td>
                    <td class="px-6 py-5 align-middle">{{ $bayar->jumlah_format }}</td>
                    <td class="px-6 py-5 align-middle font-bold {{ $bayar->status_color }}">{{ $bayar->status_label }}</td>
                    <td class="px-6 py-5 text-center">
                        <x-admin.table-action
                            viewUrl="{{ route('admin.pembayaran.show', $bayar->id_pembayaran) }}"
                            editUrl="{{ route('admin.pembayaran.edit', $bayar->id_pembayaran) }}"
                        />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-slate-400 text-[14px]">Belum ada data pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-6 border-t border-gray-100 flex items-center justify-between gap-4 bg-gray-200/50 rounded-b-[24px]">
            <span class="text-[14px] text-slate-500">Menampilkan {{ $pembayarans->firstItem() ?? 0 }} – {{ $pembayarans->lastItem() ?? 0 }} dari {{ $pembayarans->total() }} pembayaran</span>
            <div>{{ $pembayarans->links() }}</div>
        </div>
    </div>
</div>
@endsection
