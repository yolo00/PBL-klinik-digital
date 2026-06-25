@extends('dokter.layouts.dokter')
@section('title', 'Jadwal Saya')
@section('breadcrumb', 'Jadwal — Daftar Pemeriksaan Pasien')

@section('content')
<div class="mb-7 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Jadwal Pasien</h1>
        <p class="text-slate-500 text-sm mt-1">Daftar seluruh jadwal konsultasi pasien yang terdaftar pada Anda.</p>
    </div>

    {{-- Filter Tab --}}
    <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-xl">
        <a href="{{ route('dokter.jadwal', ['filter' => 'semua']) }}"
           class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ $filter === 'semua' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Semua
        </a>
        <a href="{{ route('dokter.jadwal', ['filter' => 'hari_ini']) }}"
           class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ $filter === 'hari_ini' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Hari Ini
        </a>
        <a href="{{ route('dokter.jadwal', ['filter' => 'menunggu']) }}"
           class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ $filter === 'menunggu' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Perlu Tindakan
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">Jam</th>
                    <th class="text-left">Tanggal</th>
                    <th class="text-left">Nama Pasien</th>
                    <th class="text-left">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                <tr>
                    <td class="font-bold text-slate-800">
                        {{ sprintf('%02d', $jadwal->jam) }}:00 WIB
                    </td>
                    <td class="text-slate-500 text-sm">
                        {{ $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y') : '-' }}
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
                    <td>
                        @if($jadwal->status === 'menunggu')
                            <span class="badge-menunggu flex items-center gap-1.5 w-fit">
                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse inline-block"></span>
                                Menunggu
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
                        @php
                            $isDateAllowed = false;
                            $today = \Carbon\Carbon::today();

                            if (!empty($jadwal->tanggal)) {
                                $jadwalTanggal = \Carbon\Carbon::parse($jadwal->tanggal)->startOfDay();
                                // Allowed: hari ini atau kemarin atau jadwal yang sudah lewat
                                $isDateAllowed = $jadwalTanggal->isSameDay($today) || $jadwalTanggal->isSameDay($today->copy()->subDay()) || $jadwalTanggal->lt($today);
                            }

                            $showInfoNotAllowed = (!$isDateAllowed);
                        @endphp

                        @if(in_array($jadwal->status, ['menunggu', 'dikonfirmasi']))
                            {{-- Belum ada rekam medis → buat baru --}}
                            @if(!$jadwal->rekamMedis)
                                @if($isDateAllowed)
                                    <a href="{{ route('dokter.jadwal.buat-rekam', $jadwal->id) }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-all shadow-sm">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i> Buat Rekam Medis
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 text-slate-300 rounded-lg text-xs border border-slate-100 cursor-not-allowed"
                                          title="Rekam medis hanya bisa diisi pada hari ini, kemarin, atau jadwal yang sudah berlalu.">
                                        <i class="fa-solid fa-lock text-[10px]"></i> Buat Rekam Medis
                                    </span>
                                        <div class="mt-1 text-[10px] text-amber-600 font-semibold">
                                            Rekam medis hanya bisa diisi pada jadwal hari ini, kemarin, atau yang sudah lewat.
                                        </div>
                                @endif
                            @else
                                {{-- Sudah ada rekam medis --}}
                                <a href="{{ route('dokter.rekam.show', $jadwal->rekamMedis->id) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-semibold hover:bg-emerald-100 transition-all">
                                    <i class="fa-solid fa-eye text-[10px]"></i> Lihat Rekam
                                </a>
                            @endif
                        @elseif($jadwal->status === 'selesai')
                            @if($jadwal->rekamMedis)
                                <a href="{{ route('dokter.rekam.show', $jadwal->rekamMedis->id) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition-all">
                                    <i class="fa-solid fa-eye text-[10px]"></i> Lihat Rekam
                                </a>
                            @else
                                <span class="text-slate-300 text-xs bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                    Selesai
                                </span>
                            @endif
                        @else
                            <span class="text-slate-300 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                {{-- Skenario: Jadwal belum tersedia → tampilkan informasi bahwa belum ada jadwal --}}
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center">
                                <i class="fa-solid fa-calendar-xmark text-3xl text-slate-200"></i>
                            </div>
                            <p class="font-semibold text-slate-400">
                                @if($filter === 'hari_ini')
                                    Tidak ada jadwal pemeriksaan untuk hari ini.
                                @elseif($filter === 'menunggu')
                                    Tidak ada jadwal yang memerlukan tindakan.
                                @else
                                    Belum ada jadwal praktik yang terdaftar.
                                @endif
                            </p>
                            <p class="text-xs text-slate-300">Jadwal akan muncul otomatis ketika pasien mendaftar.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($jadwals->hasPages())
    <div class="px-6 py-4 border-t border-slate-50 flex items-center justify-between">
        <p class="text-xs text-slate-400">
            Menampilkan {{ $jadwals->firstItem() }}–{{ $jadwals->lastItem() }} dari {{ $jadwals->total() }} jadwal
        </p>
        <div class="flex items-center gap-1">
            @if($jadwals->onFirstPage())
                <span class="px-3 py-1.5 text-slate-300 bg-slate-50 rounded-lg text-xs cursor-not-allowed border border-slate-100">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $jadwals->previousPageUrl() }}"
                   class="px-3 py-1.5 text-slate-600 bg-white rounded-lg text-xs hover:bg-blue-50 hover:text-blue-600 transition-all border border-slate-200">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            @foreach($jadwals->getUrlRange(1, $jadwals->lastPage()) as $page => $url)
                @if($page == $jadwals->currentPage())
                    <span class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1.5 text-slate-600 bg-white rounded-lg text-xs hover:bg-blue-50 hover:text-blue-600 transition-all border border-slate-200">{{ $page }}</a>
                @endif
            @endforeach

            @if($jadwals->hasMorePages())
                <a href="{{ $jadwals->nextPageUrl() }}"
                   class="px-3 py-1.5 text-slate-600 bg-white rounded-lg text-xs hover:bg-blue-50 hover:text-blue-600 transition-all border border-slate-200">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="px-3 py-1.5 text-slate-300 bg-slate-50 rounded-lg text-xs cursor-not-allowed border border-slate-100">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
