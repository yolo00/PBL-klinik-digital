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
                    #00164
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Dokter Pemeriksa</label>
                <div class="text-lg font-bold text-slate-800 bg-white px-4 py-2.5 rounded-xl border border-slate-200">
                    Dr. Fenni | <span class="text-emerald-600 text-sm">Dokter Umum</span>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Kunjungan</label>
                <div class="text-lg font-bold text-slate-800 bg-white px-4 py-2.5 rounded-xl border border-slate-200">
                    12 April 2026, 09:00 WIB
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
                    Pasien merasa hangat dan meriang sejak 2 hari yang lalu, disertai batuk ringan.
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
                    Demam Ringan (Influenza awal)
                </div>
            </section>

            <section>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </span>
                    Resep & Anjuran Obat
                </h3>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="text-emerald-500 mr-2">•</span>
                            <span class="text-lg text-slate-700">Paracetamol 500mg (3x1 hari setelah makan)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-500 mr-2">•</span>
                            <span class="text-lg text-slate-700">Vitamin C, 1 tablet setelah makan setiap hari hingga pulih</span>
                        </li>
                    </ul>
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
                    "Istirahat total selama 2 hari, perbanyak minum air putih hangat, dan hindari makanan berminyak."
                </div>
            </section>
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-4">
            <a href="{{ route('pasien.rekam-medis.pdf') }}" class="bg-emerald-500 text-white px-8 py-3 rounded-2xl font-bold hover:bg-emerald-600 transition shadow-md flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                    Export PDF Rekam
            </a>
        </div>
    </div>
</div>
@endsection