@extends('dokter.layouts.dokter')

@section('title', 'Input Rekam Medis')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
    <h1 class="text-2xl font-black text-slate-800 mb-2">Input Rekam Medis</h1>
    <p class="text-slate-500">
        Pasien: <span class="font-bold text-slate-800">
            {{ $jadwal->pasien->user->nama ?? 'Nama Pasien Tidak Ditemukan' }}
        </span>
    </p>

    <form action="{{ route('dokter.rekam-medis.store', $jadwal->id) }}" method="POST">
        @csrf 

        <div class="mb-4">
            <label class="block text-sm font-bold text-slate-700 mb-2">Keluhan Pasien</label>
            <textarea name="keluhan" rows="3" class="w-full p-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold text-slate-700 mb-2">Diagnosa Dokter</label>
            <textarea name="diagnosa" rows="3" class="w-full p-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold text-slate-700 mb-2">Tindakan</label>
            <textarea name="tindakan" rows="2" class="w-full p-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20"></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-bold text-slate-700 mb-2">Resep Obat</label>
            <textarea name="resep_obat" rows="2" class="w-full p-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20"></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('dokter.jadwal') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200">Batal</a>
            <button type="submit" class="px-6 py-3 bg-emerald-500 text-white rounded-xl text-sm font-bold hover:bg-emerald-600 shadow-sm">Simpan Rekam Medis</button>
        </div>
    </form> </div>
@endsection