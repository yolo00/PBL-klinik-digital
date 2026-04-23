@extends('layouts.dokter')

@section('title', 'Pengaturan Jadwal')

@section('content')
<div class="mb-10">
    <h1 class="text-[32px] font-black text-slate-800 leading-tight">Pengaturan Jadwal</h1>
    <p class="text-slate-400 font-medium mt-1">Atur jadwal operasional dan pengajuan cuti Anda.</p>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden mb-8">
    <div class="p-8 border-b border-slate-50">
        <h2 class="font-black text-slate-800 uppercase tracking-wider text-sm flex items-center gap-2">
            <i class="fa-solid fa-calendar-week text-emerald-500"></i>
            Jadwal Praktikum Rutin
        </h2>
    </div>
    <div class="p-4">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
                    <th class="px-8 py-4">Hari</th>
                    <th class="px-8 py-4">Jam Mulai</th>
                    <th class="px-8 py-4 text-center">Istirahat</th>
                    <th class="px-8 py-4 text-right">Jam Selesai</th>
                </tr>
            </thead>
            <tbody class="text-sm font-bold divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/50 transition-all">
                    <td class="px-8 py-5 text-slate-700">Senin - Kamis</td>
                    <td class="px-8 py-5 text-emerald-600">08.00</td>
                    <td class="px-8 py-5 text-center text-slate-400">12.00 - 13.00</td>
                    <td class="px-8 py-5 text-right text-slate-700">17.00</td>
                </tr>
                <tr class="hover:bg-slate-50/50 transition-all">
                    <td class="px-8 py-5 text-slate-700">Jumat</td>
                    <td class="px-8 py-5 text-emerald-600">08.00</td>
                    <td class="px-8 py-5 text-center text-slate-400">12.00 - 14.00</td>
                    <td class="px-8 py-5 text-right text-slate-700">17.00</td>
                </tr>
                <tr class="hover:bg-slate-50/50 transition-all border-b-0">
                    <td class="px-8 py-5 text-slate-700">Sabtu</td>
                    <td class="px-8 py-5 text-emerald-600">10.00</td>
                    <td class="px-8 py-5 text-center text-slate-400">12.00 - 13.00</td>
                    <td class="px-8 py-5 text-right text-slate-700">14.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden mb-8">
    <div class="p-8 border-b border-slate-50">
        <h2 class="font-black text-slate-800 uppercase tracking-wider text-sm flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-emerald-500"></i>
            Riwayat Pengajuan Cuti
        </h2>
    </div>
    <div class="p-4">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
                    <th class="px-8 py-4">Dari Tanggal</th>
                    <th class="px-8 py-4">Sampai Tanggal</th>
                    <th class="px-8 py-4 text-center">Status</th>
                    <th class="px-8 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm font-bold">
                <tr class="bg-slate-50/30 rounded-2xl">
                    <td class="px-8 py-5 text-slate-700 font-black">30 Maret 2026</td>
                    <td class="px-8 py-5 text-slate-700 font-black">30 Maret 2026</td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-wider">Disetujui</span>
                    </td>
                    <td class="px-8 py-5 text-right space-x-2">
                        <button class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase hover:bg-slate-200 transition-all">Lihat</button>
                        <button class="px-4 py-2 bg-red-50 text-red-500 rounded-xl text-[10px] font-black uppercase hover:bg-red-100 transition-all">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-10">
    <h2 class="font-black text-slate-800 uppercase tracking-wider text-sm flex items-center gap-2 mb-8">
        <i class="fa-solid fa-paper-plane text-emerald-500"></i>
        Form Pengajuan Cuti
    </h2>
    
    <form action="#" method="POST" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-3">
                <label class="text-[12px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Tanggal Mulai</label>
                <div class="relative group">
                    <i class="fa-solid fa-calendar-plus absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors"></i>
                    <input type="date" class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-bold transition-all outline-none">
                </div>
            </div>
            <div class="space-y-3">
                <label class="text-[12px] font-black text-slate-400 uppercase tracking-widest ml-1">Sampai Tanggal</label>
                <div class="relative group">
                    <i class="fa-solid fa-calendar-check absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors"></i>
                    <input type="date" class="w-full pl-14 pr-6 py-4 bg-slate-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-bold transition-all outline-none">
                </div>
                <p class="text-[10px] text-slate-400 font-medium ml-1 italic">* Kosongkan jika hanya cuti sehari</p>
            </div>
        </div>

        <div class="space-y-3">
            <label class="text-[12px] font-black text-slate-400 uppercase tracking-widest ml-1">Alasan Pengajuan</label>
            <textarea rows="4" placeholder="Tuliskan alasan pengajuan cuti Anda di sini..." class="w-full px-6 py-5 bg-slate-50 rounded-[24px] border-none focus:ring-2 focus:ring-emerald-500/20 text-sm font-medium transition-all outline-none resize-none"></textarea>
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-4 border-t border-slate-50">
            <div class="flex items-center gap-3 text-amber-600 bg-amber-50 px-5 py-3 rounded-2xl border border-amber-100/50">
                <i class="fa-solid fa-circle-info text-sm"></i>
                <p class="text-[11px] font-bold">Mohon ajukan cuti minimal 3 hari sebelum tanggal pelaksanaan.</p>
            </div>
            <button type="submit" class="bg-slate-800 text-white px-10 py-4 rounded-2xl text-xs font-black uppercase tracking-[1px] hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-100 transition-all">
                Ajukan Cuti
            </button>
        </div>
    </form>
</div>
@endsection
