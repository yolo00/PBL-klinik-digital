@extends('dokter.layouts.dokter')
@section('title', 'Detail Rekam Medis')

@section('content')
<div class="bg-white p-10 rounded-[30px] border border-slate-100 shadow-sm max-w-4xl mx-auto">

    <div class="flex justify-between items-start mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Rekam Medis #{{ $rekamMedis->id }}</h2>
            <p class="text-slate-400 text-sm mt-1">
                Tanggal: {{ $rekamMedis->created_at->format('d F Y, H:i') }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Export PDF (FITUR BARU) --}}
            <a href="{{ route('dokter.rekam.export-pdf', $rekamMedis->id) }}"
               class="px-5 py-2.5 bg-emerald-500 text-white rounded-xl font-bold hover:bg-emerald-600 transition-all text-xs uppercase flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ url()->previous() }}"
               class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-all text-xs uppercase">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Info Pasien & Dokter --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-6 bg-slate-50 rounded-2xl">
        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Pasien</label>
            <p class="mt-1 font-bold text-slate-800">
                {{ $rekamMedis->jadwal->pasien->user->nama ?? '-' }}
            </p>
        </div>
        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Dokter Pemeriksa</label>
            <p class="mt-1 font-bold text-slate-800">
                {{ $rekamMedis->jadwal->dokter->user->nama ?? '-' }}
            </p>
        </div>
        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Konsultasi</label>
            <p class="mt-1 font-bold text-slate-800">
                {{ $rekamMedis->jadwal->tanggal ? \Carbon\Carbon::parse($rekamMedis->jadwal->tanggal)->format('d F Y') : '-' }}
            </p>
        </div>
        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Jam</label>
            <p class="mt-1 font-bold text-slate-800">
                {{ $rekamMedis->jadwal->jam_format ?? '-' }} WIB
            </p>
        </div>
    </div>

    {{-- Keluhan & Diagnosa --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-slate-50 p-6 rounded-2xl">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Keluhan Pasien</label>
            <p class="mt-3 text-slate-700 font-medium leading-relaxed">
                {{ $rekamMedis->keluhan ?? 'Tidak ada data keluhan' }}
            </p>
        </div>
        <div class="bg-slate-50 p-6 rounded-2xl">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Diagnosa</label>
            <p class="mt-3 text-lg font-bold text-emerald-600 leading-relaxed">
                {{ $rekamMedis->diagnosa ?? '-' }}
            </p>
        </div>
    </div>

    {{-- Tindakan --}}
    @if($rekamMedis->tindakan)
    <div class="mb-8">
        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tindakan Medis</label>
        <div class="mt-3 p-6 border border-slate-100 rounded-2xl text-slate-700 leading-relaxed">
            {{ $rekamMedis->tindakan }}
        </div>
    </div>
    @endif

    {{-- Catatan --}}
    <div class="mb-8">
        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Catatan Tambahan</label>
        <div class="mt-3 p-6 border border-slate-100 rounded-2xl text-slate-700 leading-relaxed">
            {{ $rekamMedis->catatan ?? 'Tidak ada catatan tambahan.' }}
        </div>
    </div>

    {{-- Resep Obat --}}
    @if($rekamMedis->reseps->count() > 0)
    <div>
        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-4">Resep Obat</label>
        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-left">Nama Obat</th>
                        <th class="px-6 py-4 text-left">Dosis</th>
                        <th class="px-6 py-4 text-left">Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($rekamMedis->reseps as $resep)
                    <tr>
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $resep->obat }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $resep->dosis }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $resep->aturan_pakai }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection