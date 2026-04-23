@extends('layouts.dokter')

@section('title', 'Jadwal Saya')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-[30px] font-black text-slate-800 leading-tight">Jadwal Pasien</h1>
        <p class="text-slate-400 font-medium mt-1">Daftar pemeriksaan pasien untuk hari ini.</p>
    </div>
    
    <div class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
        <button class="w-10 h-10 flex items-center justify-center text-slate-400 hover:bg-slate-50 rounded-xl transition-all">
            <i class="fa-solid fa-chevron-left text-xs"></i>
        </button>
        <div class="px-4 flex flex-col items-center">
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Hari Ini</span>
            <span class="text-sm font-bold text-slate-700">23 April 2026</span>
        </div>
        <button class="w-10 h-10 flex items-center justify-center text-slate-400 hover:bg-slate-50 rounded-xl transition-all">
            <i class="fa-solid fa-chevron-right text-xs"></i>
        </button>
    </div>
</div>

<div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm mb-8 flex flex-col md:flex-row gap-4">
    <div class="flex-1 relative">
        <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-sm"></i>
        <input type="text" placeholder="Cari nama pasien..." class="w-full pl-12 pr-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all">
    </div>
    <select class="px-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-bold text-slate-600 outline-none cursor-pointer">
        <option>Semua Status</option>
        <option>Mendatang</option>
        <option>Selesai</option>
    </select>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[11px] font-black text-slate-400 uppercase tracking-[2px]">
                    <th class="px-8 py-6">Jam Kerja</th>
                    <th class="px-8 py-6">Informasi Pasien</th>
                    <th class="px-8 py-6">Status Jadwal</th>
                    <th class="px-8 py-6">Rekam Medis</th>
                    <th class="px-8 py-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/80 transition-all group">
                    <td class="px-8 py-6">
                        <span class="text-sm font-black text-slate-800">11.00 WIB</span>
                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">Sesi Pagi</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-sm font-bold text-slate-700 block">Aprillia Bunga</span>
                        <span class="text-[11px] text-slate-400 font-medium italic">Pasien Umum</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                            Mendatang
                        </span>
                    </td>
                    <td class="px-8 py-6 text-slate-400 text-xs font-bold italic">
                        Belum dibuat *
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center">
                        <a href="{{ route('dokter.edit-rekam', ['id' => 'JDWL001']) }}" 
                        class="inline-block px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase hover:bg-emerald-500 hover:text-white transition-all text-center">
                            Lihat Rekam Medis
                        </a>
                        </div>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50/80 transition-all opacity-70">
                    <td class="px-8 py-6">
                        <span class="text-sm font-black text-slate-800">09.30 WIB</span>
                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">Sesi Pagi</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-sm font-bold text-slate-700 block">Budi Santoso</span>
                        <span class="text-[11px] text-slate-400 font-medium italic">Karyawan Polibatam</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                            Selesai
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <button class="text-emerald-600 text-xs font-black underline hover:text-emerald-800">
                            Lihat Rekam Medis
                        </button>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center">
                            <span class="text-slate-300 text-[10px] font-bold uppercase tracking-widest italic">Tidak ada aksi</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 flex items-center justify-center gap-4">
    <button class="w-10 h-10 rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-white hover:text-emerald-600 hover:shadow-sm transition-all shadow-sm">
        <i class="fa-solid fa-arrow-left text-xs"></i>
    </button>
    <div class="px-6 py-2 bg-white rounded-xl border border-slate-100 shadow-sm text-[11px] font-black text-slate-500 uppercase tracking-[2px]">
        Hasil 1 - 10 / <span class="text-emerald-600">41 Pasien</span>
    </div>
    <button class="w-10 h-10 rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-white hover:text-emerald-600 hover:shadow-sm transition-all shadow-sm">
        <i class="fa-solid fa-arrow-right text-xs"></i>
    </button>
</div>
@endsection