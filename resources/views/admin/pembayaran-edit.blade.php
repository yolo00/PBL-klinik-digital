@extends('admin.layouts.app')
@section('title', 'Edit Pembayaran')
@section('content')
<x-admin.form action="{{ route('admin.pembayaran.index') }}" method="POST" title="Edit Pembayaran" subtitle="Fitur update akan segera tersedia." backUrl="{{ route('admin.pembayaran.show', $pembayaran->id_pembayaran) }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">Jadwal</label>
            <input type="text"
                value="{{ $pembayaran->jadwal->pasien?->user?->nama ?? '(Tanpa Pasien)' }} — {{ $pembayaran->jadwal->tanggal->format('d M Y') }} ({{ $pembayaran->jadwal->dokter->dr_name }})"
                disabled class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jumlah</label>
            <input type="text" value="{{ $pembayaran->jumlah_format }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nomor Struk</label>
            <input type="text" value="{{ $pembayaran->nomor_struk ?? '—' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Metode Pembayaran</label>
            <input type="text" value="{{ strtoupper($pembayaran->metode) }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Status</label>
            <input type="text" value="{{ $pembayaran->status_label }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
    </div>
</x-admin.form>
@endsection
