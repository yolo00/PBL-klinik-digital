@extends('admin.layouts.app')
@section('title', 'Edit Rekam Medis')
@section('content')
<x-admin.form action="{{ route('admin.rekam-medis.index') }}" method="POST" title="Edit Rekam Medis" subtitle="Fitur update akan segera tersedia." backUrl="{{ route('admin.rekam-medis.show', $rekamMedis->id_rekam) }}">

    <div class="grid grid-cols-1 gap-6">
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jadwal</label>
            <input type="text"
                value="{{ $rekamMedis->jadwal->pasien?->user?->nama ?? '(Tanpa Pasien)' }} — {{ $rekamMedis->jadwal->tanggal->format('d M Y') }} ({{ $rekamMedis->jadwal->dokter->dr_name }})"
                disabled class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Keluhan</label>
            <textarea disabled rows="3"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed resize-none">{{ $rekamMedis->keluhan ?? '' }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Diagnosa</label>
            <textarea disabled rows="3"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed resize-none">{{ $rekamMedis->diagnosa ?? '' }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Catatan Tambahan</label>
            <textarea disabled rows="3"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed resize-none">{{ $rekamMedis->catatan ?? '' }}</textarea>
        </div>
    </div>
</x-admin.form>
@endsection
