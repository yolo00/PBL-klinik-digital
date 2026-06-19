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
        <div class="p-8 bg-slate-50/50 border-b border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">No. Rekam Medis</label>
                <div class="text-lg font-bold text-slate-800 bg-white px-4 py-2.5 rounded-xl border border-slate-200 inline-block min-w-[120px]">
                    #{{ str_pad($rekamMedis->id, 5, '0', STR_PAD_LEFT) }}
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Dokter Pemeriksa</label>
                <div class="text-lg font-bold text-slate-800 bg-white px-4 py-2.5 rounded-xl border border-slate-200">
                    {{ $rekamMedis->jadwal->dokter->user->nama ?? '-' }} | 
                    <span class="text-emerald-600 text-sm">{{ $rekamMedis->jadwal->dokter->spesialisasi->nama ?? 'Dokter Umum' }}</span>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Kunjungan</label>
                <div class="text-lg font-bold text-slate-800 bg-white px-4 py-2.5 rounded-xl border border-slate-200">
                    {{ \Carbon\Carbon::parse($rekamMedis->created_at)->translatedFormat('d F Y, H:i') }} WIB
                </div>
            </div>
        </div>

        <div class="p-8 space-y-10">
            <section>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </span>
                    Keluhan Pasien
                </h3>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed text-lg">
                    {{ $rekamMedis->keluhan }}
                </div>
            </section>

            <section>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                    Diagnosa Dokter
                </h3>
                <div class="bg-blue-50/30 p-6 rounded-2xl border border-blue-100 text-blue-900 font-bold text-lg">
                    {{ $rekamMedis->diagnosa }}
                </div>
            </section>

           <section>
    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center">
        Resep & Anjuran Obat
    </h3>
    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
        {{-- Karena relasinya hasMany, kita cek apakah ada data --}}
        @if(isset($rekamMedis->resep) && $rekamMedis->resep->isNotEmpty())
            <ul class="space-y-3">
                @foreach($rekamMedis->resep as $item)
                    <li class="flex items-start">
                        <span class="text-emerald-500 mr-2">•</span>
                        <span class="text-lg text-slate-700">
                            {{ $item->obat }} - {{ $item->dosis }} ({{ $item->aturan_pakai }})
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-slate-500 italic">Tidak ada resep obat.</p>
        @endif
    </div>
</section>

            <section>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </span>
                    Catatan Dokter
                </h3>
                <div class="bg-amber-50/20 p-6 rounded-2xl border border-amber-100 text-slate-600 italic text-lg leading-relaxed">
                    {{ $rekamMedis->catatan ?? 'Tidak ada catatan tambahan.' }}
                </div>
            </section>
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-4">
            <button class="bg-emerald-500 text-white px-8 py-3 rounded-2xl font-bold hover:bg-emerald-600 transition shadow-md flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                Export PDF Rekam
            </button>
        </div>
    </div>
</div>
@endsection