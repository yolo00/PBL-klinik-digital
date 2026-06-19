@extends('dokter.layouts.dokter')

@section('title', 'Dashboard')

@section('breadcrumb', 'Beranda — Ringkasan Pelayanan Kesehatan')

@section('content')

{{-- Greeting --}}
<div class="mb-7">
    <h1 class="text-2xl font-bold text-slate-800">
        Selamat datang, {{ auth()->user()->nama ?? 'Dokter' }} 👋
    </h1>
    <p class="text-slate-500 text-sm mt-1">
        Berikut ringkasan jadwal pemeriksaan dan aktivitas pelayanan kesehatan Anda hari ini.
    </p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7">

    {{-- Pasien Hari Ini --}}
    <div class="stat-card">
        <div class="stat-icon bg-blue-50 text-blue-600">
            <i class="fa-solid fa-user-group"></i>
        </div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">
            Pasien Hari Ini
        </p>
        <p class="text-3xl font-bold text-slate-800">
            {{ $jadwalHariIni }}
        </p>
        <a href="{{ route('dokter.jadwal') }}"
            class="text-blue-600 text-xs font-semibold mt-2 inline-flex items-center gap-1 hover:gap-2 transition-all">
            Lihat detail
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    {{-- Semua Jadwal --}}
    <div class="stat-card">
        <div class="stat-icon bg-indigo-50 text-indigo-600">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">
            Seluruh Jadwal Pemeriksaan
        </p>
        <p class="text-3xl font-bold text-slate-800">
            {{ $semuaJadwal }}
        </p>
        <a href="{{ route('dokter.jadwal') }}"
            class="text-blue-600 text-xs font-semibold mt-2 inline-flex items-center gap-1 hover:gap-2 transition-all">
            Lihat semua
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    {{-- Rekam Belum Terisi --}}
    <div class="stat-card">
        <div class="stat-icon bg-amber-50 text-amber-500">
            <i class="fa-solid fa-clipboard-list"></i>
        </div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">
            Rekam Medis Menunggu Pengisian
        </p>
        <p class="text-3xl font-bold text-slate-800">
            {{ $rekamBelumTerisi }}
        </p>
        <a href="{{ route('dokter.rekam-medis') }}"
            class="text-amber-500 text-xs font-semibold mt-2 inline-flex items-center gap-1 hover:gap-2 transition-all">
            Perlu ditinjau
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    {{-- Status Praktik --}}
    <div class="stat-card">
        <div class="stat-icon bg-emerald-50 text-emerald-600">
            <i class="fa-solid fa-stethoscope"></i>
        </div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">
            Status Pelayanan
        </p>
        <p class="text-2xl font-bold text-emerald-600">
            Aktif
        </p>
        <a href="{{ route('dokter.pengaturan') }}"
            class="text-emerald-600 text-xs font-semibold mt-2 inline-flex items-center gap-1 hover:gap-2 transition-all">
            Atur status
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
</div>

{{-- Bottom Section --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Tabel Jadwal Hari Ini --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-50">
            <h2 class="font-bold text-slate-700 text-sm uppercase tracking-wider">
                Jadwal Pemeriksaan Hari Ini
            </h2>
            <a href="{{ route('dokter.jadwal') }}" class="text-blue-600 text-xs font-semibold hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead>
                    <tr>
                        <th class="text-left">Nama Pasien</th>
                        <th class="text-left">Waktu Pemeriksaan</th>
                        <th class="text-left">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalList as $jadwal)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-user text-blue-400 text-xs"></i>
                                </div>
                                <span class="font-semibold text-slate-800">
                                    {{ $jadwal->pasien->user->nama ?? 'Pasien Tidak Ditemukan' }}
                                </span>
                            </div>
                        </td>
                        <td class="font-semibold text-slate-600">
                            {{ sprintf('%02d', $jadwal->jam) }}:00 WIB
                        </td>
                        <td>
                            @php
                                $badgeMap = [
                                    'menunggu' => 'badge-menunggu',
                                    'dikonfirmasi'=> 'badge-konfirmasi',
                                    'selesai'=> 'badge-selesai',
                                    'dibatalkan'=> 'badge-batal',
                                ];
                                $badge = $badgeMap[$jadwal->status] ?? 'badge-menunggu';
                                $labelMap = [
                                    'menunggu'=>'Menunggu',
                                    'dikonfirmasi'=>'Dikonfirmasi',
                                    'selesai'=>'Selesai',
                                    'dibatalkan'=>'Dibatalkan',
                                ];
                            @endphp
                            <span class="{{ $badge }}">
                                {{ $labelMap[$jadwal->status] ?? ucfirst($jadwal->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($jadwal->status !== 'selesai' && $jadwal->status !== 'dibatalkan')
                            <a href="{{ route('dokter.jadwal.buat-rekam', $jadwal->id) }}"
                                class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-all">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                Mulai Pemeriksaan
                            </a>
                            @else
                            <span class="text-slate-300 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-10">
                            <div class="flex flex-col items-center gap-2 text-slate-300">
                                <i class="fa-solid fa-calendar-xmark text-3xl"></i>
                                <p class="text-sm font-medium">
                                    Belum ada jadwal pemeriksaan pasien hari ini.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mini Calendar --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        @php
            $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            $hariIni = (int) date('j');
            $bulanIni = (int) date('n');
            $tahunIni = (int) date('Y');
            $totalHari = (int) date('t');
            $hariPertama = (int) date('N', mktime(0,0,0,$bulanIni,1,$tahunIni));
        @endphp

        <h2 class="font-bold text-slate-700 text-sm uppercase tracking-wider mb-5">
            {{ $bulan[$bulanIni - 1] }} {{ $tahunIni }}
        </h2>

        <div class="grid grid-cols-7 gap-1 text-center mb-3">
            @foreach(['S','S','R','K','J','S','M'] as $h)
            <span class="text-[10px] font-bold text-slate-400">{{ $h }}</span>
            @endforeach
        </div>

        <div class="grid grid-cols-7 gap-1 text-center">
            @for($i = 1; $i < $hariPertama; $i++)
            <span></span>
            @endfor
            @for($i = 1; $i <= $totalHari; $i++)
            <div class="flex justify-center">
                <span class="cal-day {{ $i === $hariIni ? 'today' : '' }}">
                    {{ $i }}
                </span>
            </div>
            @endfor
        </div>

        <div class="mt-5 pt-4 border-t border-slate-50">
            <p class="text-xs text-slate-400 font-medium">Hari ini</p>
            <p class="text-sm font-bold text-slate-700 mt-0.5">
                {{ date('l, d') }} {{ $bulan[$bulanIni - 1] }} {{ $tahunIni }}
            </p>
        </div>
    </div>

</div>

@endsection