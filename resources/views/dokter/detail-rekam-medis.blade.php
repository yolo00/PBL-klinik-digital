@extends('dokter.layouts.dokter')
@section('title', 'Detail Rekam Medis')
@section('breadcrumb', 'Rekam Medis — Detail Catatan')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Rekam Medis #{{ $rekamMedis->id }}</h1>
            <p class="text-slate-400 text-sm mt-1">
                <i class="fa-regular fa-clock mr-1"></i>
                {{ $rekamMedis->created_at->format('d F Y, H:i') }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('dokter.rekam.export-pdf', $rekamMedis->id) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition-all shadow-sm">
                <i class="fa-solid fa-file-pdf"></i> Ekspor PDF
            </a>
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Info Pasien & Dokter --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5">
        <p class="text-[11px] font-bold text-blue-500 uppercase tracking-widest mb-4">Informasi Kunjungan</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold mb-1">Nama Pasien</p>
                <p class="font-bold text-slate-800">{{ $rekamMedis->jadwal->pasien->user->nama ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold mb-1">Dokter Pemeriksa</p>
                <p class="font-bold text-slate-800">{{ $rekamMedis->jadwal->dokter->user->nama ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold mb-1">Tanggal Konsultasi</p>
                <p class="font-bold text-slate-800">
                    {{ $rekamMedis->jadwal->tanggal ? \Carbon\Carbon::parse($rekamMedis->jadwal->tanggal)->format('d F Y') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold mb-1">Jam</p>
                <p class="font-bold text-slate-800">{{ $rekamMedis->jadwal->jam_format ?? '-' }} WIB</p>
            </div>
        </div>
    </div>

    {{-- Keluhan & Diagnosa --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Keluhan Pasien</p>
            <p class="text-slate-700 leading-relaxed">{{ $rekamMedis->keluhan ?? 'Tidak ada data keluhan.' }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6">
            <p class="text-[11px] font-bold text-blue-400 uppercase tracking-widest mb-3">Diagnosis Dokter</p>
            <p class="text-blue-700 font-semibold leading-relaxed text-lg">{{ $rekamMedis->diagnosa ?? '-' }}</p>
        </div>
    </div>

    {{-- Tindakan --}}
    @if($rekamMedis->tindakan)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5">
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Tindakan Medis</p>
        <p class="text-slate-700 leading-relaxed">{{ $rekamMedis->tindakan }}</p>
    </div>
    @endif

    {{-- Catatan --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5">
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Catatan Tambahan</p>
        <p class="text-slate-700 leading-relaxed">{{ $rekamMedis->catatan ?? 'Tidak ada catatan tambahan.' }}</p>
    </div>

    {{-- Resep Obat --}}
    @if($rekamMedis->reseps && $rekamMedis->reseps->count() > 0)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-2">
            <i class="fa-solid fa-pills text-blue-500 text-sm"></i>
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Resep Obat</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead>
                    <tr>
                        <th class="text-left">Nama Obat</th>
                        <th class="text-left">Dosis</th>
                        <th class="text-left">Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekamMedis->reseps as $resep)
                    <tr>
                        <td class="font-semibold text-slate-800">{{ $resep->obat }}</td>
                        <td class="text-slate-600">{{ $resep->dosis }}</td>
                        <td class="text-slate-600">{{ $resep->aturan_pakai }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
