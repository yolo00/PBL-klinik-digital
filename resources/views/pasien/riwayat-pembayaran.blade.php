
@extends('pasien.layouts.app')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('pasien.riwayat') }}" class="text-slate-400 hover:text-slate-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Riwayat Pembayaran</h3>
    </div>

    <div class="bg-white rounded-[2rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-8 right-8">
            <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-emerald-100">Lunas</span>
        </div>

        <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-8">Struk pembayaran anda</p>

        <div class="bg-slate-50 rounded-3xl p-8 mb-6 border border-slate-100">
            <div class="mb-6">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nominal</p>
                <h4 class="text-3xl font-black text-slate-900">Rp 50.000</h4>
            </div>
            
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kode payment :</p>
                    <p class="text-xs font-mono text-slate-600 break-all">0020102040ID.w.bpk.www.593502</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Alamat pembayar :</p>
                    <p class="text-xs font-bold text-slate-700">089671168857</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Informasi Jadwal</p>
            
            <div class="flex flex-col gap-5">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Tanggal dan sesi</p>
                    <p class="text-sm font-bold text-slate-800">8 April 2026 . 11.00 WIB</p>
                </div>

                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Dokter</p>
                    <p class="text-sm font-bold text-slate-800">Dr. Fenni | Dokter umum</p>
                </div>
            </div>
        </div>

        <button class="w-full mt-8 flex items-center justify-center gap-2 py-4 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400 font-bold text-xs hover:bg-slate-50 transition uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Unduh Struk PDF
        </button>
    </div>
</div>
@endsection