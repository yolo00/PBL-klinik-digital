@extends('admin.layouts.app')
@section('title', 'Edit Data Jadwal')
@section('content')
<x-admin.form action="{{ route('admin.jadwal.index') }}" method="POST" title="Edit Data Jadwal" subtitle="Fitur update akan segera tersedia." backUrl="{{ route('admin.jadwal.show', $jadwal->id_jadwal) }}">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Dokter</label>
            <input type="text" value="{{ $jadwal->dokter->dr_name }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Pasien</label>
            <input type="text" value="{{ $jadwal->pasien?->user?->nama ?? '(Tanpa Pasien)' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Tanggal</label>
            <input type="text" value="{{ $jadwal->tanggal->format('d M Y') }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jam</label>
            <input type="text" value="{{ \Illuminate\Support\Str::substr($jadwal->jam, 0, 5) }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">Status</label>
            <input type="text" value="{{ $jadwal->status_label }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
    </div>
</x-admin.form>
@endsection
