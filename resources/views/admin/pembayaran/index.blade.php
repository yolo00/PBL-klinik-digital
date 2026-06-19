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

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. struk / nama pasien…"
            class="flex-1 min-w-[200px] max-w-[400px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all">
        <select name="status" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[160px] appearance-none cursor-pointer">
            <option value="">Status : Semua</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
            <option value="lunas"    {{ request('status') === 'lunas'    ? 'selected' : '' }}>Lunas</option>
            <option value="batal"    {{ request('status') === 'batal'    ? 'selected' : '' }}>Batal</option>
        </select>
        <select name="metode" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[160px] appearance-none cursor-pointer">
            <option value="">Metode : Semua</option>
            <option value="cash"     {{ request('metode') === 'cash'     ? 'selected' : '' }}>Cash</option>
            <option value="qris"     {{ request('metode') === 'qris'     ? 'selected' : '' }}>QRIS</option>
            <option value="transfer" {{ request('metode') === 'transfer' ? 'selected' : '' }}>Transfer</option>
        </select>
        <select name="sort" class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[180px] appearance-none cursor-pointer">
            <option value="terbaru" {{ request('sort','terbaru') === 'terbaru' ? 'selected' : '' }}>Sortir : Terbaru</option>
            <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Sortir : Terlama</option>
        </select>
        <button type="submit" class="px-6 py-3 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm">Cari</button>
        <a href="{{ route('admin.pembayaran.index') }}" class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">Reset</a>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">ID</th>
                    <th class="px-6 py-5">Pasien</th>
                    <th class="px-6 py-5">Dokter</th>
                    <th class="px-6 py-5">Metode</th>
                    <th class="px-6 py-5">Total Biaya</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-center">Kelola</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                @forelse($pembayarans as $bayar)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 align-middle text-slate-500">#{{ $bayar->id }}</td>
                    <td class="px-6 py-5 align-middle">{{ $bayar->jadwal->pasien?->user?->nama ?? '—' }}</td>
                    <td class="px-6 py-5 align-middle text-slate-600">{{ $bayar->jadwal->dokter?->user?->nama ?? '—' }}</td>
                    <td class="px-6 py-5 align-middle">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[12px] font-medium
                            {{ $bayar->metode === 'cash' ? 'bg-blue-50 text-blue-700' : ($bayar->metode === 'qris' ? 'bg-purple-50 text-purple-700' : 'bg-cyan-50 text-cyan-700') }}">
                            {{ $bayar->metode_label }}
                        </span>
                    </td>
                    <td class="px-6 py-5 align-middle font-semibold text-slate-800">{{ $bayar->jumlah_format }}</td>
                    <td class="px-6 py-5 align-middle">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[12px] font-semibold {{ $bayar->status_badge }}">
                            {{ $bayar->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <x-admin.table-action
                            viewUrl="{{ route('admin.pembayaran.show', $bayar->id) }}"
                            editUrl="{{ route('admin.pembayaran.edit', $bayar->id) }}"
                            deleteUrl="{{ route('admin.pembayaran.destroy', $bayar->id) }}"
                        />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-slate-400 text-[14px]">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Belum ada data pembayaran.</span>
                        </div>
                    </td>
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
