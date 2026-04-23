@extends('dokter.layouts.dokter')

@section('title', 'Lihat dan Edit Rekam')

@section('content')
<div class="mb-10">
    <h1 class="text-[32px] font-black text-slate-800 leading-tight">Lihat dan Edit Rekam</h1>
    <p class="text-slate-400 font-medium mt-1">Kelola dan tinjau kembali data rekam medis yang telah Anda terbitkan.</p>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-10">
    
    <div class="mb-8 space-y-6">
        <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
            <i class="fa-solid fa-file-medical text-emerald-500"></i>
            Cari Data Rekam
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-5 relative group">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors"></i>
                <input type="text" placeholder="Cari nama pasien..." class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none">
            </div>
            
            <div class="md:col-span-4 relative group">
                <i class="fa-solid fa-calendar-day absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors"></i>
                <input type="date" class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-bold text-slate-500 outline-none cursor-pointer appearance-none">
            </div>
            
            <div class="md:col-span-3">
                <button class="w-full py-4 bg-slate-100 text-slate-500 rounded-2xl text-sm font-black uppercase hover:bg-slate-200 transition-all">
                    Reset Filter
                </button>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <select class="px-6 py-3 bg-slate-100/50 rounded-xl border-none text-[11px] font-black text-slate-500 uppercase tracking-wider outline-none cursor-pointer">
                <option>Sortir : Terbaru</option>
                <option>Terlama</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto rounded-3xl border border-slate-50">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[2px]">
                    <th class="px-8 py-5">ID</th>
                    <th class="px-8 py-5">Nama Pasien / NIK</th>
                    <th class="px-8 py-5">Nama Dokter</th>
                    <th class="px-8 py-5">Tanggal Terbit</th>
                    <th class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm font-bold divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/80 transition-all">
                    <td class="px-8 py-6 text-slate-400 font-medium italic">00164</td>
                    <td class="px-8 py-6">
                        <span class="text-slate-800 block">Aprillia Bunga</span>
                        <span class="text-[11px] text-slate-400 font-mono">3312501032</span>
                    </td>
                    <td class="px-8 py-6 text-emerald-600">Dr. Fenni</td>
                    <td class="px-8 py-6 text-slate-500">4 April 2026</td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center gap-2">
                            <button class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase hover:bg-slate-200 transition-all">Lihat</button>
                            <a href="{{ route('dokter.edit-rekam', ['id' => '00164']) }}" 
                            class="inline-block px-6 py-2.5 bg-slate-800 text-white rounded-xl text-[10px] font-black uppercase hover:bg-emerald-600 transition-all shadow-md text-center">
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>

                @for($i=0; $i<6; $i++)
                <tr class="hover:bg-slate-50/80 transition-all opacity-40">
                    <td class="px-8 py-6 text-slate-300 italic">Id</td>
                    <td class="px-8 py-6 text-slate-300 italic">Nama Pasien / NIK</td>
                    <td class="px-8 py-6 text-slate-300 italic font-medium">Dokter</td>
                    <td class="px-8 py-6 text-slate-300 italic font-medium">Tanggal</td>
                    <td class="px-8 py-6 text-center">
                        <div class="flex justify-center gap-2">
                            <div class="w-20 h-8 bg-slate-100 rounded-xl"></div>
                            <div class="w-20 h-8 bg-slate-100 rounded-xl"></div>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex items-center justify-center gap-4">
        <button class="w-10 h-10 rounded-xl border border-slate-100 flex items-center justify-center text-slate-300"><i class="fa-solid fa-chevron-left"></i></button>
        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
            Menunjukkan hasil 1 - 10 / <span class="text-emerald-600 font-black uppercase">39 Rekam</span>
        </p>
        <button class="w-10 h-10 rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition-all">
            <i class="fa-solid fa-chevron-right text-xs"></i>
        </button>
    </div>
</div>
@endsection
