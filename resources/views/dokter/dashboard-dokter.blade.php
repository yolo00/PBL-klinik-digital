@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="mb-10">
    <h1 class="text-[32px] font-black text-slate-800 leading-tight">Selamat datang, Dr. Fenni 👋</h1>
    <p class="text-slate-400 font-medium mt-1">Berikut ringkasan jadwal dan aktivitas medis Anda hari ini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    @php
        $stats = [
            ['title' => 'Jadwal Hari Ini', 'value' => '1 Jadwal', 'icon' => 'fa-clock'],
            ['title' => 'Semua Jadwal', 'value' => '2 Jadwal', 'icon' => 'fa-calendar-check'],
            ['title' => 'Rekam Belum Terisi', 'value' => '1 Rekam', 'icon' => 'fa-clipboard-list'],
            ['title' => 'Status Anda', 'value' => 'Aktif', 'icon' => 'fa-circle-check', 'color' => 'text-emerald-500'],
        ];
    @endphp

    @foreach($stats as $s)
    <div class="bg-white p-7 rounded-[32px] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-all">
                <i class="fa-solid {{ $s['icon'] }} text-sm"></i>
            </div>
        </div>
        <p class="text-[12px] font-black text-slate-400 uppercase tracking-wider">{{ $s['title'] }}</p>
        <p class="text-2xl font-black {{ $s['color'] ?? 'text-slate-800' }} mt-1">{{ $s['value'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h2 class="font-black text-slate-800 uppercase tracking-wider text-sm">Jadwal Hari Ini</h2>
            <button class="text-emerald-600 font-bold text-xs hover:underline">Lihat Semua</button>
        </div>
        <div class="p-2">
            <table class="w-full">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase">
                        <th class="px-6 py-4 text-left">Nama Pasien</th>
                        <th class="px-6 py-4 text-left">Jam</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-bold">
                    <tr class="hover:bg-slate-50 rounded-2xl transition-all">
                        <td class="px-6 py-5 text-slate-700">Budi Santoso</td>
                        <td class="px-6 py-5 text-slate-400 font-semibold text-xs uppercase tracking-tighter">11.00 WIB</td>
                        <td class="px-6 py-5">
                            <span class="px-4 py-1.5 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase">Mendatang</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button class="bg-slate-800 text-white px-6 py-2 rounded-full text-[10px] font-black uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200">Mulai</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-black text-slate-800 uppercase tracking-wider text-sm">April 2026</h2>
            <div class="flex gap-2">
                <button class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-all text-xs"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-all text-xs"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
        
        <div class="grid grid-cols-7 gap-y-4 text-center mb-8">
            @php $days = ['S','S','R','K','J','S','M']; @endphp
            @foreach($days as $d)
                <span class="text-[10px] font-black text-slate-300 uppercase">{{ $d }}</span>
            @endforeach
            @for($i = 1; $i <= 30; $i++)
                <span class="text-sm font-bold {{ $i == 23 ? 'bg-emerald-500 text-white w-8 h-8 flex items-center justify-center rounded-xl mx-auto shadow-lg shadow-emerald-100' : 'text-slate-700 py-1' }}">{{ $i }}</span>
            @endfor
        </div>

        <div class="pt-6 border-t border-slate-50">
            <p class="text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest">Informasi Penting</p>
            <div class="flex items-start gap-3">
                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full mt-1.5"></div>
                <p class="text-xs font-bold text-slate-600 leading-relaxed">24 April - 25 April Anda mengajukan cuti tahunan.</p>
            </div>
        </div>
    </div>
</div>
@endsection