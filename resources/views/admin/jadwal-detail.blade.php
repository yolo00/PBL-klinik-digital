@extends('admin.layouts.app')
@section('title', 'Detail Jadwal')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Detail Jadwal</h2>
                <p class="text-[14px] text-slate-500 mt-1">ID Jadwal #{{ $jadwal->id_jadwal }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal) }}"
                    class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors">Edit</a>
                <a href="{{ route('admin.jadwal.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">Kembali</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-admin.detail-card label="Pasien"   :value="$jadwal->pasien?->user?->nama ?? '(Tanpa Pasien)'" />
            <x-admin.detail-card label="Dokter"   :value="$jadwal->dokter->dr_name" />
            <x-admin.detail-card label="Tanggal"  :value="$jadwal->tanggal->format('d M Y')" />
            <x-admin.detail-card label="Jam"      :value="\Illuminate\Support\Str::substr($jadwal->jam, 0, 5)" />
            <x-admin.detail-card label="Status"   :value="$jadwal->status_label" />
            <x-admin.detail-card label="Dibuat"   :value="$jadwal->created_at ? \Carbon\Carbon::parse($jadwal->created_at)->format('d M Y, H:i') : '—'" />
        </div>
    </div>

    {{-- Rekam Medis terkait --}}
    @if($jadwal->rekamMedis)
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <h3 class="text-[16px] font-bold text-slate-800 mb-4">Rekam Medis Terkait</h3>
        <div class="grid grid-cols-1 gap-4">
            <x-admin.detail-card label="Keluhan"  :value="$jadwal->rekamMedis->keluhan  ?? '—'" />
            <x-admin.detail-card label="Diagnosa" :value="$jadwal->rekamMedis->diagnosa ?? '—'" />
            <x-admin.detail-card label="Catatan"  :value="$jadwal->rekamMedis->catatan  ?? '—'" />
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.rekam-medis.show', $jadwal->rekamMedis->id_rekam) }}"
                class="text-[13px] text-slate-500 hover:text-slate-700 underline transition-colors">Lihat Rekam Medis Lengkap →</a>
        </div>
    </div>
    @endif

    {{-- Pembayaran terkait --}}
    @if($jadwal->pembayaran)
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <h3 class="text-[16px] font-bold text-slate-800 mb-4">Pembayaran Terkait</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-admin.detail-card label="Nomor Struk" :value="$jadwal->pembayaran->nomor_struk ?? '—'" />
            <x-admin.detail-card label="Jumlah"      :value="$jadwal->pembayaran->jumlah_format" />
            <x-admin.detail-card label="Metode"      :value="strtoupper($jadwal->pembayaran->metode)" />
            <x-admin.detail-card label="Status"      :value="$jadwal->pembayaran->status_label" />
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.pembayaran.show', $jadwal->pembayaran->id_pembayaran) }}"
                class="text-[13px] text-slate-500 hover:text-slate-700 underline transition-colors">Lihat Pembayaran Lengkap →</a>
        </div>
    </div>
    @endif
</div>
@endsection
