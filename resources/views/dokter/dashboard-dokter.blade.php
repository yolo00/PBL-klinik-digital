@extends('dokter.layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="mb-10">
    <h1 class="text-[32px] font-black text-slate-800 leading-tight">Selamat datang, {{ auth()->user()->nama ?? 'Dokter' }} 👋</h1>
    <p class="text-slate-400 font-medium mt-1">Berikut ringkasan jadwal dan aktivitas medis Anda hari ini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    @php
        $stats = [
            ['title' => 'Jadwal Hari Ini', 'value' => $jadwalHariIni . ' Jadwal', 'icon' => 'fa-clock'],
            ['title' => 'Semua Jadwal', 'value' => $semuaJadwal . ' Jadwal', 'icon' => 'fa-calendar-check'],
            ['title' => 'Rekam Belum Terisi', 'value' => $rekamBelumTerisi . ' Rekam', 'icon' => 'fa-clipboard-list'],
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
            <a href="{{ route('dokter.jadwal') }}" class="text-emerald-600 font-bold text-xs hover:underline">Lihat Semua</a>
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
                    @forelse($jadwalList as $jadwal)
                    <tr class="hover:bg-slate-50 rounded-2xl transition-all">
                    <td class="px-6 py-5">
                        {{ $jadwal->pasien->user->nama ?? 'Pasien Tidak Ditemukan' }}
                    </td>
                        <td class="px-6 py-5 text-slate-400 font-semibold text-xs uppercase tracking-tighter">
                            {{ $jadwal->jam }}
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-4 py-1.5 {{ $jadwal->status == 'menunggu' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }} rounded-full text-[10px] font-black uppercase">
                                {{ $jadwal->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($jadwal->status !== 'selesai')
                            <a href="{{ route('dokter.jadwal.buat-rekam', $jadwal->id) }}" 
                            class="bg-slate-800 text-white px-6 py-2 rounded-full text-[10px] font-black uppercase hover:bg-emerald-600 transition-all shadow-lg">
                            Mulai
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-slate-400 font-medium">
                            Tidak ada antrian pasien untuk Anda hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm p-8">
        <h2 class="font-black text-slate-800 uppercase tracking-wider text-sm mb-8">{{ date('F Y') }}</h2>
        <div class="grid grid-cols-7 gap-y-4 text-center mb-8">
            @php $days = ['S','S','R','K','J','S','M']; @endphp
            @foreach($days as $d) <span class="text-[10px] font-black text-slate-300 uppercase">{{ $d }}</span> @endforeach
            @for($i = 1; $i <= date('t'); $i++)
                <span class="text-sm font-bold {{ $i == date('j') ? 'bg-emerald-500 text-white w-8 h-8 flex items-center justify-center rounded-xl mx-auto shadow-lg' : 'text-slate-700 py-1' }}">{{ $i }}</span>
            @endfor
        </div>
    </div>
</div>
@endsection