@extends('dokter.layouts.dokter')

@section('title', $is_edit ? 'Edit Rekam Medis' : 'Tambah Rekam Medis')

@section('content')
<div class="mb-10">
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('dokter.rekam-medis') }}" class="w-10 h-10 bg-white rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:text-emerald-500 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-[32px] font-black text-slate-800 leading-tight">
            {{ $is_edit ? 'Edit Rekam Medis' : 'Tambah Rekam Medis Baru' }}
        </h1>
    </div>
    <p class="text-slate-400 font-medium ml-14">
        {{ $is_edit ? 'Perbarui data pemeriksaan kesehatan pasien secara akurat.' : 'Masukkan data rekam medis hasil pemeriksaan pasien.' }}
    </p>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-10">
    <form action="{{ route('dokter.rekam-medis.update', $id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Pasien</label>
                <input type="text" value="{{ $jadwal_info->nama_pasien ?? 'Tidak Diketahui' }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-500 font-bold outline-none cursor-not-allowed">
            </div>
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Dokter Pemeriksa</label>
                <input type="text" value="{{ $jadwal_info->nama_dokter ?? 'Tidak Diketahui' }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-500 font-bold outline-none cursor-not-allowed">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Jadwal</label>
            <div class="relative">
                <i class="fa-solid fa-calendar absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                <input type="text" value="{{ now()->translatedFormat('d F Y') }}" readonly class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-500 font-bold outline-none cursor-not-allowed">
            </div>
        </div>

        <hr class="border-slate-50">

        <div class="space-y-6 relative z-10">
            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest ml-1">Keluhan Pasien</label>
                <textarea name="keluhan" rows="3" placeholder="Ringkasan keluhan pasien..." required class="w-full px-6 py-4 bg-white rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none cursor-text">{{ trim($rekam_medis->keluhan ?? '') }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest ml-1">Diagnosa</label>
                <textarea name="diagnosa" rows="3" placeholder="Diagnosa penyakit pasien..." required class="w-full px-6 py-4 bg-white rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none cursor-text">{{ trim($rekam_medis->diagnosa ?? '') }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest ml-1">Resep Obat / Catatan Medis</label>
                <textarea name="catatan" rows="4" placeholder="Tuliskan resep obat beserta aturan pakai di sini..." required class="w-full px-6 py-4 bg-white rounded-2xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none cursor-text">{{ trim($rekam_medis->catatan ?? '') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-10 py-4 bg-slate-800 text-white rounded-2xl text-xs font-black uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200">
                {{ $is_edit ? 'Simpan Perubahan' : 'Simpan Rekam Medis' }}
            </button>
        </div>
    </form>
</div>
@endsection