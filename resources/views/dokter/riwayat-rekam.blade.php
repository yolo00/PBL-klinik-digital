@extends('dokter.layouts.dokter')

@section('title', 'Riwayat Rekam Medis Pasien')

@section('content')
<div class="mb-10 flex items-center gap-4">
    <a href="{{ route('dokter.pasien') }}" class="w-12 h-12 bg-white border border-slate-100 shadow-sm rounded-xl flex items-center justify-center text-slate-600 hover:text-emerald-600 hover:border-emerald-100 transition-all">
        <i class="fa-solid fa-arrow-left text-sm"></i>
    </a>
    <div>
        <h1 class="text-[32px] font-black text-slate-800 leading-tight">Riwayat Rekam Medis</h1>
        <p class="text-slate-400 font-medium mt-1">Seluruh log rekam medis pasien di UniHealth.</p>
    </div>
</div>

<div class="bg-slate-900 rounded-[30px] p-8 mb-8 text-white shadow-xl flex flex-col md:flex-row justify-between gap-6">
    <div class="space-y-2">
        <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-[9px] font-black uppercase tracking-wider">Profil Pasien</span>
        <h2 class="text-2xl font-black tracking-tight">Aprillia Bunga</h2>
        <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm font-medium text-slate-300">
            <div><i class="fa-solid fa-id-card mr-2 text-emerald-400"></i>NIM/NIK: <span class="font-mono text-white">3312501032</span></div>
            <div><i class="fa-solid fa-venus-mars mr-2 text-purple-400"></i>Perempuan</div>
            <div><i class="fa-solid fa-phone mr-2 text-blue-400"></i>089671168857</div>
        </div>
    </div>
    <div class="flex items-center bg-slate-800/50 border border-slate-700/50 p-5 rounded-2xl self-start md:self-center">
        <div class="text-center md:text-right">
            <span class="text-xs text-slate-400 font-bold block uppercase tracking-wider">Total Riwayat Berobat</span>
            <span class="text-3xl font-black text-emerald-400">2 <span class="text-sm font-medium text-slate-300">Rekam Medis</span></span>
        </div>
    </div>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-10">
    <div class="mb-6">
        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
            <i class="fa-solid fa-clock-history text-emerald-500"></i>
            Daftar Log Pemeriksaan Pasien
        </h3>
    </div>

    <div class="overflow-x-auto rounded-3xl border border-slate-50">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[2px]">
                    <th class="px-8 py-5">ID Rekam</th>
                    <th class="px-8 py-5">Tanggal Kunjungan</th>
                    <th class="px-8 py-5">Dokter Pemeriksa</th>
                    <th class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm font-bold divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/80 transition-all">
                    <td class="px-8 py-6 text-slate-400 font-medium">00164</td>
                    <td class="px-8 py-6 text-slate-800">10 April 2026</td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold">Dr. Rudi</span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center">
                            <button class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase hover:bg-slate-200 transition-all">
                                <i class="fa-solid fa-eye mr-1"></i> Lihat
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50/80 transition-all">
                    <td class="px-8 py-6 text-slate-400 font-medium">00195</td>
                    <td class="px-8 py-6 text-slate-800">02 June 2026</td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold">Dr. Fenni (Saya)</span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center gap-2">
                            <button class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase hover:bg-slate-200 transition-all">
                                <i class="fa-solid fa-eye mr-1"></i> Lihat
                            </button>
                            <a href="{{ route('dokter.pasien') }}" class="w-12 h-12 bg-white border border-slate-100 shadow-sm rounded-xl flex items-center justify-center text-slate-600 hover:text-emerald-600 hover:border-emerald-100 transition-all">
    <i class="fa-solid fa-arrow-left text-sm"></i>
</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection