@extends('admin.layouts.app')
@section('title', 'Detail Cuti Dokter')
@section('content')
<div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
    <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
        <div>
            <h2 class="text-[20px] font-bold text-slate-800">Detail Cuti Dokter</h2>
            <p class="text-[14px] text-slate-500 mt-1">ID Cuti #{{ $cuti->id_cuti }}</p>
        </div>
        <div class="flex gap-3">
            @if($cuti->status === 'pending')
            <form action="{{ route('admin.cuti-dokter.terima', $cuti->id_cuti) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-emerald-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-emerald-600 transition-colors">Terima</button>
            </form>
            <form action="{{ route('admin.cuti-dokter.tolak', $cuti->id_cuti) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-rose-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-rose-600 transition-colors">Tolak</button>
            </form>
            @endif
            <a href="{{ route('admin.jadwal-sistem') }}"
                class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-admin.detail-card label="Nama Dokter"     :value="$cuti->dokter->dr_name" />
        <x-admin.detail-card label="Spesialis"       :value="$cuti->dokter->spesialis" />
        <x-admin.detail-card label="Dari Tanggal"    :value="$cuti->dari_tanggal->format('d M Y')" />
        <x-admin.detail-card label="Sampai Tanggal"  :value="$cuti->sampai_tanggal->format('d M Y')" />
        <x-admin.detail-card label="Durasi"          :value="$cuti->dari_tanggal->diffInDays($cuti->sampai_tanggal) + 1 . ' hari'" />
        <x-admin.detail-card label="Status"          :value="$cuti->status_label" />
        <x-admin.detail-card label="Alasan"          :value="$cuti->alasan" class="md:col-span-2" />
        <x-admin.detail-card label="Diajukan Pada"   :value="$cuti->created_at ? \Carbon\Carbon::parse($cuti->created_at)->format('d M Y, H:i') : '—'" />
    </div>
</div>
@endsection
