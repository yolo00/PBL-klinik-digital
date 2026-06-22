@extends('pasien.layouts.app')
@section('title', 'Detail Rekam Medis')
@section('content')
<div class="animate-fade-in px-4 py-6 md:px-8">
    <div class="mb-8">
        <a href="{{ route('pasien.rekam-medis') }}" class="inline-flex items-center text-sm font-bold text-emerald-600 hover:text-emerald-700 transition mb-4 group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Rekam Medis & Resep</h1>
        <p class="text-lg text-slate-500 mt-2">Detail lengkap hasil kunjungan dan anjuran dokter.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden">
        {{-- Tampilan Grid Disesuaikan agar lebih rapi --}}
        <div class="p-8 bg-slate-50/50 border-b border-slate-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">No. Rekam Medis</label>
                <div class="text-lg font-bold text-slate-800">
                    #{{ str_pad($rekamMedis->id, 5, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Dokter Pemeriksa</label>
                <div class="text-sm font-bold text-slate-800 leading-tight">
                    {{ $rekamMedis->jadwal->dokter->user->nama ?? '-' }}
                    <p class="text-emerald-600 font-medium mt-1">{{ $rekamMedis->jadwal->dokter->spesialisasi->nama ?? 'Dokter Umum' }}</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Kunjungan</label>
                <div class="text-sm font-bold text-slate-800">
                    {{ \Carbon\Carbon::parse($rekamMedis->jadwal->tanggal)->translatedFormat('d M Y') }}
                    <p class="text-slate-500 font-medium">{{ $rekamMedis->jadwal->jam_format ?? '00:00' }} WIB</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu Pengisian</label>
                <div class="text-sm font-bold text-slate-800">
                    {{ \Carbon\Carbon::parse($rekamMedis->created_at)->translatedFormat('d M Y') }}
                    <p class="text-emerald-600 font-medium">Pukul {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('H:i') }} WIB</p>
                </div>
            </div>
        </div>

        {{-- Sisa konten di bawah tidak diubah --}}
        <div class="p-8 space-y-10">
            <section>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center">Keluhan Pasien</h3>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed text-lg">
                    {{ $rekamMedis->keluhan }}
                </div>
            </section>

            <section>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center">Diagnosa Dokter</h3>
                <div class="bg-blue-50/30 p-6 rounded-2xl border border-blue-100 text-blue-900 font-bold text-lg">
                    {{ $rekamMedis->diagnosa }}
                </div>
            </section>

            <section>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center">Resep & Anjuran Obat</h3>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    @if(isset($rekamMedis->resep) && $rekamMedis->resep->isNotEmpty())
                        <ul class="space-y-3">
                            @foreach($rekamMedis->resep as $item)
                                <li class="flex items-start">
                                    <span class="text-emerald-500 mr-2">•</span>
                                    <span class="text-lg text-slate-700">{{ $item->obat }} - {{ $item->dosis }} ({{ $item->aturan_pakai }})</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-slate-500 italic">Tidak ada resep obat.</p>
                    @endif
                </div>
            </section>

            <section>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center">Catatan Dokter</h3>
                <div class="bg-amber-50/20 p-6 rounded-2xl border border-amber-100 text-slate-600 italic text-lg leading-relaxed">
                    {{ $rekamMedis->catatan ?? 'Tidak ada catatan tambahan.' }}
                </div>
            </section>
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-4">
            <a href="{{ route('pasien.rekam-medis.pdf', $rekamMedis->id) }}" class="flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl transition">
                Export PDF Rekam
            </a>
        </div>
    </div>
</div>
@endsection