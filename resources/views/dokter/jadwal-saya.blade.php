@extends('dokter.layouts.dokter')
@section('title', 'Jadwal Saya')
@section('breadcrumb', 'Jadwal — Daftar Pemeriksaan Pasien')

@section('content')
<div class="mb-7">
    <h1 class="text-2xl font-bold text-slate-800">Jadwal Pasien</h1>
    <p class="text-slate-500 text-sm mt-1">Daftar seluruh pemeriksaan pasien yang terdaftar pada Anda.</p>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">Jam Kerja</th>
                    <th class="text-left">Nama Pasien</th>
                    <th class="text-left">Tanggal</th>
                    <th class="text-left">Status Jadwal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                <tr>
                    <td>
                        <span class="font-bold text-slate-800">{{ sprintf('%02d', $jadwal->jam) }}:00 WIB</span>
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user text-blue-400 text-xs"></i>
                            </div>
                            <span class="font-semibold text-slate-800">
                                {{ $jadwal->pasien->user->nama ?? 'Nama Tidak Ditemukan' }}
                            </span>
                        </div>
                    </td>
                    <td class="text-slate-500 text-sm">
                        {{ $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y') : '-' }}
                    </td>
                    <td>
                        @if($jadwal->status === 'menunggu')
                            <span class="badge-menunggu flex items-center gap-1.5 w-fit">
                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse inline-block"></span> Menunggu
                            </span>
                        @elseif($jadwal->status === 'dikonfirmasi')
                            <span class="badge-konfirmasi w-fit inline-block">Dikonfirmasi</span>
                        @elseif($jadwal->status === 'selesai')
                            <span class="badge-selesai w-fit inline-block">Selesai</span>
                        @else
                            <span class="badge-batal w-fit inline-block">Dibatalkan</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($jadwal->status === 'menunggu' || $jadwal->status === 'dikonfirmasi')
                            <a href="{{ route('dokter.jadwal.buat-rekam', $jadwal->id) }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-all shadow-sm">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i> Buat Rekam Medis
                            </a>
                        @else
                            <span class="text-slate-300 text-xs font-medium bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                Pemeriksaan Selesai
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-14 text-center">
                        <div class="flex flex-col items-center gap-2 text-slate-300">
                            <i class="fa-solid fa-calendar-xmark text-4xl"></i>
                            <p class="text-sm font-medium text-slate-400">Tidak ada jadwal pemeriksaan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
