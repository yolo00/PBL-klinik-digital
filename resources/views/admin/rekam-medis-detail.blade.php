@extends('admin.layouts.app')
@section('title', 'Detail Rekam Medis')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Detail Rekam Medis</h2>
                <p class="text-[14px] text-slate-500 mt-1">ID Rekam #{{ $rekamMedis->id_rekam }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.rekam-medis.edit', $rekamMedis->id_rekam) }}"
                    class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors">Edit</a>
                <a href="{{ route('admin.rekam-medis.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">Kembali</a>
            </div>
        </div>

        {{-- Info Jadwal --}}
        <div class="mb-6 p-4 bg-slate-50 rounded-[16px] border border-slate-100">
            <p class="text-[12px] font-bold text-slate-400 uppercase tracking-wide mb-3">Informasi Jadwal</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-[12px] text-slate-500 mb-1">Pasien</p>
                    <p class="text-[14px] font-semibold text-slate-800">{{ $rekamMedis->jadwal->pasien?->user?->nama ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[12px] text-slate-500 mb-1">Dokter</p>
                    <p class="text-[14px] font-semibold text-slate-800">{{ $rekamMedis->jadwal->dokter->dr_name }}</p>
                </div>
                <div>
                    <p class="text-[12px] text-slate-500 mb-1">Tanggal Kunjungan</p>
                    <p class="text-[14px] font-semibold text-slate-800">{{ $rekamMedis->jadwal->tanggal->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <x-admin.detail-card label="Keluhan"           :value="$rekamMedis->keluhan  ?? '—'" />
            <x-admin.detail-card label="Diagnosa"          :value="$rekamMedis->diagnosa ?? '—'" />
            <x-admin.detail-card label="Catatan Tambahan"  :value="$rekamMedis->catatan  ?? '—'" />
            <x-admin.detail-card label="Dibuat"            :value="$rekamMedis->created_at ? \Carbon\Carbon::parse($rekamMedis->created_at)->format('d M Y, H:i') : '—'" />
        </div>
    </div>
</div>
@endsection
