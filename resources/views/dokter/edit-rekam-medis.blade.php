@extends('layouts.dokter')

@section('title', 'Edit Rekam Medis')

@section('content')
<div class="mb-10">
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('dokter.rekam-medis') }}" class="w-10 h-10 bg-white rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:text-emerald-500 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-[32px] font-black text-slate-800 leading-tight">Edit Rekam Medis</h1>
    </div>
    <p class="text-slate-400 font-medium ml-14">Perbarui data pemeriksaan kesehatan pasien secara akurat.</p>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-10">
    <form action="#" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Pasien</label>
                <input type="text" value="Aprillia Bunga" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-500 font-bold outline-none cursor-not-allowed">
            </div>
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Dokter Pemeriksa</label>
                <input type="text" value="Dr. Fenni Patrik Simanjuntak" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-500 font-bold outline-none cursor-not-allowed">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Jadwal</label>
            <div class="relative">
                <i class="fa-solid fa-calendar absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                <input type="text" value="4 April 2026" readonly class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-500 font-bold outline-none cursor-not-allowed">
            </div>
        </div>

        <hr class="border-slate-50">

        <div class="space-y-6">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest ml-1">Keluhan Pasien</label>
                <textarea rows="3" placeholder="Ringkasan keluhan pasien..." class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none resize-none">Pasien mengeluhkan pusing dan demam sejak kemarin malam.</textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest ml-1">Diagnosa</label>
                <textarea rows="3" placeholder="Diagnosa penyakit pasien..." class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none resize-none">Gejala awal influenza.</textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest ml-1">Resep Obat</label>
                <textarea rows="3" placeholder="Obat pemulihan pasien..." class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none resize-none">Paracetamol 500mg (3x1), Vitamin C.</textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest ml-1">Catatan Tambahan (Opsional)</label>
                <textarea rows="2" placeholder="Catatan singkat..." class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none resize-none">Istirahat total selama 2 hari.</textarea>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-10 py-4 bg-slate-800 text-white rounded-2xl text-xs font-black uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
