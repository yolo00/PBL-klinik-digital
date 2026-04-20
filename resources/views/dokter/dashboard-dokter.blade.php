@extends('admin.layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="p-6">
    <h1 class="text-[26px] font-black text-slate-800 mb-8">Selamat datang, Dr. Fenni 👋</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-[#edf2f4] p-7 rounded-[32px] border border-white shadow-sm hover:shadow-md transition-all">
            <p class="text-[13px] font-bold text-slate-500 mb-2">Jadwal hari ini</p>
            <p class="text-xl font-black text-slate-800">1 Jadwal</p>
        </div>
        <div class="bg-[#edf2f4] p-7 rounded-[32px] border border-white shadow-sm hover:shadow-md transition-all">
            <p class="text-[13px] font-bold text-slate-500 mb-2">Semua Jadwal Mendatang</p>
            <p class="text-xl font-black text-slate-800">2 Jadwal</p>
        </div>
        <div class="bg-[#edf2f4] p-7 rounded-[32px] border border-white shadow-sm hover:shadow-md transition-all">
            <p class="text-[13px] font-bold text-slate-500 mb-2">Rekam Belum Terisi</p>
            <p class="text-xl font-black text-slate-800">1 Rekam</p>
        </div>
        <div class="bg-[#edf2f4] p-7 rounded-[32px] border border-white shadow-sm hover:shadow-md transition-all">
            <p class="text-[13px] font-bold text-slate-500 mb-2">Status anda hari ini</p>
            <p class="text-xl font-black text-emerald-600">Aktif</p>
        </div>
    </div>

    <div class="bg-[#edf2f4] rounded-[32px] p-8 mb-8 border border-white shadow-sm">
        <h2 class="text-[14px] font-black text-slate-800 mb-6 uppercase tracking-widest">Jadwal hari ini:</h2>
        
        <div class="bg-white rounded-[24px] overflow-hidden shadow-sm border border-slate-50">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[13px] text-slate-400 font-bold border-b border-slate-50">
                        <th class="px-8 py-5">Nama</th>
                        <th class="px-8 py-5">Jam</th>
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-slate-800 font-bold">
                    <tr class="hover:bg-slate-50/50 transition-all">
                        <td class="px-8 py-6">Budi</td>
                        <td class="px-8 py-6 text-slate-500 font-semibold">11.00</td>
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 bg-amber-50 text-amber-600 rounded-full text-[12px]">Mendatang</span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <button class="bg-[#a0a6b1] text-white px-6 py-2 rounded-full text-[12px] font-bold uppercase tracking-wider hover:bg-slate-500 transition-all shadow-sm">
                                mulai
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-[40px] p-10 border border-slate-100 shadow-sm flex flex-col lg:flex-row gap-12">
        <div class="flex-1">
            <div class="flex justify-between items-center mb-10">
                <button class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition-all shadow-sm">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <h3 class="font-black text-slate-800 text-xl tracking-tight">April 2026</h3>
                <button class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition-all shadow-sm">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-7 gap-y-8 text-center text-sm font-bold text-slate-400">
                <div class="text-[11px] uppercase tracking-widest text-slate-300">Min</div>
                <div class="text-[11px] uppercase tracking-widest text-slate-300">Sen</div>
                <div class="text-[11px] uppercase tracking-widest text-slate-300">Sel</div>
                <div class="text-[11px] uppercase tracking-widest text-slate-300">Rab</div>
                <div class="text-[11px] uppercase tracking-widest text-slate-300">Kam</div>
                <div class="text-[11px] uppercase tracking-widest text-slate-300">Jum</div>
                <div class="text-[11px] uppercase tracking-widest text-slate-300">Sab</div>

                <span class="opacity-20">30</span><span class="opacity-20">31</span>
                <span class="text-slate-800">1</span><span class="text-slate-800">2</span><span class="text-slate-800">3</span><span class="text-slate-800">4</span><span class="text-slate-800">5</span>
                <span class="text-slate-800">6</span><span class="text-slate-800">7</span>
                <span class="relative inline-block mx-auto">
                    <span class="text-slate-900 z-10 relative border-b-4 border-emerald-400 pb-1">8</span>
                </span>
                <span class="text-slate-800">9</span><span class="text-slate-800">10</span><span class="text-slate-800">11</span><span class="text-slate-800">12</span>
                <span class="text-slate-800">13</span><span class="text-slate-800">14</span><span class="text-slate-800">15</span><span class="text-slate-800">16</span><span class="text-slate-800">17</span><span class="text-slate-800">18</span><span class="text-slate-800">19</span>
            </div>
        </div>

        <div class="w-full lg:w-80 border-t lg:border-t-0 lg:border-l border-slate-100 pt-10 lg:pt-0 lg:pl-12">
            <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-6">Informasi :</h4>
            <div class="space-y-6">
                <div class="flex items-start gap-3">
                    <span class="text-emerald-500 font-black text-lg leading-none">*</span>
                    <p class="text-[13px] text-slate-500 font-medium leading-relaxed">Klinik libur atau cuti</p>
                </div>
                <p class="text-[13px] text-slate-900 font-bold border-b-2 border-emerald-100 inline-block">Garis bawah menandakan hari ini</p>
                
                <div class="mt-8 p-6 bg-red-50 rounded-[24px] border border-red-100 shadow-sm">
                    <p class="text-[13px] font-bold text-red-600 leading-relaxed">
                        <i class="fa-solid fa-calendar-minus mr-2"></i>
                        24 April - 25 April anda mengajukan cuti
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
