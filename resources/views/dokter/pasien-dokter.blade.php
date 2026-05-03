@extends('dokter.layouts.dokter')

@section('title', 'Semua Pasien')

@section('content')
<div class="mb-10">
    <h1 class="text-[32px] font-black text-slate-800 leading-tight">Semua Pasien</h1>
    <p class="text-slate-400 font-medium mt-1">Lihat data semua pasien, termasuk riwayat rekam medis mereka.</p>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-10">
    
    <div class="mb-8 space-y-6">
        <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
            <i class="fa-solid fa-filter text-emerald-500"></i>
            Cari Data Pasien
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-6 relative group">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors"></i>
                <input type="text" placeholder="Cari nama atau NIK..." class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none" value="Cari">
            </div>
            
            <div class="md:col-span-3">
                <select class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-bold text-slate-600 outline-none cursor-pointer appearance-none">
                    <option>Jenis Kelamin : -</option>
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>
            </div>
            
            <div class="md:col-span-3">
                <button class="w-full py-4 bg-slate-100 text-slate-500 rounded-2xl text-sm font-black uppercase hover:bg-slate-200 transition-all">
                    Reset Filter
                </button>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <select class="px-6 py-3 bg-slate-100/50 rounded-xl border-none text-[11px] font-black text-slate-500 uppercase tracking-wider outline-none cursor-pointer">
                <option>Sortir : Nama A - Z</option>
                <option>Terbaru</option>
                <option>Terlama</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto shadow-sm rounded-3xl border border-slate-50">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[2px]">
                    <th class="px-8 py-5">ID</th>
                    <th class="px-8 py-5">Nama Pasien</th>
                    <th class="px-8 py-5">NIM / NIK</th>
                    <th class="px-8 py-5">Nomor HP</th>
                    <th class="px-8 py-5">Jenis Kelamin</th>
                    <th class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm font-bold divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/80 transition-all">
                    <td class="px-8 py-6 text-slate-400 font-medium">00168</td>
                    <td class="px-8 py-6 text-slate-800">Aprillia Bunga</td>
                    <td class="px-8 py-6 text-slate-500 font-mono">3312501032</td>
                    <td class="px-8 py-6 text-slate-500">089671168857</td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-lg text-[10px] font-black uppercase">Perempuan</span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('dokter.edit-rekam', ['id' => '00168']) }}" 
                            class="inline-block px-5 py-2 bg-slate-800 text-white rounded-xl text-[10px] font-black uppercase hover:bg-emerald-600 transition-all shadow-md shadow-slate-100 text-center">
                                Rekam
                            </a>
                            <button class="px-5 py-2 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase hover:bg-white border border-slate-200 transition-all">Jadwal</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-8 bg-slate-50 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <span class="text-sm font-medium text-slate-500">Menampilkan <span class="text-slate-900 font-bold">1 - 1</span> dari <span class="text-slate-900 font-bold"> 1 </span> Pasien </span>
        <div class="flex gap-3">
            <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed transition hover:bg-slate-50">Sebelumnya</button>
            <button class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black text-xs shadow-lg shadow-emerald-100">1</button>
            <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed transition hover:bg-slate-50">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection
