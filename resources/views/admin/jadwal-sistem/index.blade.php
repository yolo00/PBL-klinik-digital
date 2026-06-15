@extends('admin.layouts.app')
@section('title', 'Jadwal Sistem')
@section('content')

{{-- ════════════════════════════════════════════════════════════════
     BLOK 1 — Jadwal Operasional Harian + Kalender
════════════════════════════════════════════════════════════════ --}}
<div class="space-y-6">

<div class="bg-white rounded-[24px] shadow-sm border border-slate-100 overflow-hidden">

    {{-- Header Blok 1 --}}
    <div class="px-8 py-6 border-b border-slate-100">
        <h2 class="text-[20px] font-bold text-slate-800">Jadwal Operasional</h2>
        <p class="text-[14px] text-slate-500 mt-1">
            Jam buka klinik setiap hari. Klik <span class="font-semibold">Edit Jam</span> untuk mengubah jam operasional harian.
        </p>
    </div>

    <div class="flex flex-col xl:flex-row divide-y xl:divide-y-0 xl:divide-x divide-slate-100">

        {{-- ── Tabel Harian ── --}}
        <div class="flex-1 overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[13px] text-slate-500 font-semibold uppercase tracking-wide border-b border-slate-100 bg-slate-50">
                        <th class="px-6 py-4">Hari</th>
                        <th class="px-6 py-4">Jam Buka</th>
                        <th class="px-6 py-4">Jam Tutup</th>
                        <th class="px-6 py-4">Istirahat</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-slate-50">
                    @foreach($jadwalHarian as $jh)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-semibold">{{ $jh->hari }}</td>

                        @if($jh->is_libur)
                        <td colspan="3" class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-rose-600 bg-rose-50 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Tutup
                            </span>
                        </td>
                        @else
                        <td class="px-6 py-4 tabular-nums">{{ $jh->jam_buka_format }}</td>
                        <td class="px-6 py-4 tabular-nums">{{ $jh->jam_tutup_format }}</td>
                        <td class="px-6 py-4 text-slate-500 text-[13px] tabular-nums">{{ $jh->jam_istirahat_display }}</td>
                        @endif

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.jadwal-sistem.harian.edit', $jh) }}"
                               class="px-4 py-1.5 rounded-full bg-gray-200 hover:bg-blue-100 hover:text-blue-700 text-slate-700 text-[13px] transition-colors shadow-sm">
                                Edit Jam
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── Kalender ── --}}
        <div class="w-full xl:w-[340px] shrink-0 p-6">

            {{-- Navigasi bulan --}}
            <form method="GET" action="{{ route('admin.jadwal-sistem') }}" id="formKalender" class="hidden">
                <input type="hidden" name="search"         value="{{ request('search') }}">
                <input type="hidden" name="sort"           value="{{ request('sort') }}">
                <input type="hidden" name="filter_tanggal" value="{{ request('filter_tanggal') }}">
                <input type="hidden" name="bulan" id="inputBulan" value="{{ $bulan }}">
                <input type="hidden" name="tahun" id="inputTahun" value="{{ $tahun }}">
            </form>

            <div class="flex items-center justify-between mb-5">
                <button type="button" onclick="kalenderNav(-1)"
                        class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <span class="text-[15px] font-bold text-slate-800">
                    {{ \Carbon\Carbon::create($tahun, $bulan)->locale('id')->isoFormat('MMMM YYYY') }}
                </span>
                <button type="button" onclick="kalenderNav(1)"
                        class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            {{-- Header hari --}}
            <div class="grid grid-cols-7 mb-1">
                @foreach(['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $h)
                <div class="text-center text-[11px] font-bold text-slate-400 py-1">{{ $h }}</div>
                @endforeach
            </div>

            {{-- Grid tanggal --}}
            @php
                $firstDay    = \Carbon\Carbon::create($tahun, $bulan, 1);
                $startPad    = $firstDay->dayOfWeekIso - 1; // Senin = 0
                $daysInMonth = $firstDay->daysInMonth;
                $today       = now()->format('Y-m-d');
            @endphp

            <div class="grid grid-cols-7 gap-[2px]">
                @for($p = 0; $p < $startPad; $p++)
                    <div></div>
                @endfor

                @for($d = 1; $d <= $daysInMonth; $d++)
                    @php
                        $dateStr = sprintf('%04d-%02d-%02d', $tahun, $bulan, $d);
                        $jadwal  = $tanggalKhususBulan[$dateStr] ?? null;
                        $isToday = ($dateStr === $today);
                    @endphp

                    <div class="relative group aspect-square flex items-center justify-center rounded-lg text-[12px] font-medium cursor-default
                        {{ $isToday ? 'outline outline-2 outline-offset-[-2px] outline-slate-800' : '' }}
                        {{ $jadwal?->is_libur ? 'bg-rose-100 text-rose-700 font-bold' : ($jadwal ? 'bg-blue-100 text-blue-700 font-bold' : 'hover:bg-slate-100 text-slate-700') }}
                    ">
                        {{ $d }}

                        {{-- Tooltip untuk tanggal khusus --}}
                        @if($jadwal)
                        <div class="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 hidden group-hover:flex z-20">
                            <div class="bg-slate-800 text-white text-[11px] rounded-lg px-2.5 py-1.5 whitespace-nowrap shadow-lg">
                                @if($jadwal->keterangan)
                                    {{ $jadwal->keterangan }}
                                @elseif(!$jadwal->is_libur && $jadwal->jam_buka !== null)
                                    Buka {{ $jadwal->jam_buka_format }}–{{ $jadwal->jam_tutup_format }}
                                @else
                                    Libur
                                @endif
                                <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-800"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                @endfor
            </div>

            {{-- Legenda --}}
            <div class="mt-5 flex items-center gap-4 text-[12px] text-slate-500">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded bg-rose-100 border border-rose-300"></span> Libur
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded bg-blue-100 border border-blue-300"></span> Jam khusus
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded border-2 border-slate-800"></span> Hari ini
                </span>
            </div>
        </div>{{-- end kalender --}}
    </div>{{-- end flex --}}
</div>{{-- end blok 1 --}}


{{-- ════════════════════════════════════════════════════════════════
     BLOK 2 — Tabel Tanggal Khusus
════════════════════════════════════════════════════════════════ --}}
<div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">

    {{-- Header + Tombol Tambah --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-[20px] font-bold text-slate-800">Tanggal Libur Klinik</h2>
            <p class="text-[13px] text-slate-500 mt-0.5">Libur nasional, cuti bersama, atau operasional jam berbeda.</p>
        </div>
        <a href="{{ route('admin.jadwal-sistem.create') }}"
           class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Jadwal
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.jadwal-sistem') }}" class="flex flex-wrap gap-3 mb-4">
        <input type="hidden" name="bulan" value="{{ $bulan }}">
        <input type="hidden" name="tahun" value="{{ $tahun }}">

        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari ID atau keterangan…"
               class="flex-1 min-w-[200px] max-w-[400px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all shadow-[0_2px_10px_rgb(0,0,0,0.02)]">

        <input type="date" name="filter_tanggal" value="{{ request('filter_tanggal') }}"
               class="px-4 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition-all text-slate-700 shadow-[0_2px_10px_rgb(0,0,0,0.02)]">

        <select name="sort"
                class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[180px] appearance-none cursor-pointer">
            <option value="terbaru"   {{ request('sort','terbaru') === 'terbaru'   ? 'selected' : '' }}>Sortir: Terbaru</option>
            <option value="terlama"   {{ request('sort') === 'terlama'   ? 'selected' : '' }}>Sortir: Terlama</option>
            <option value="mendekati" {{ request('sort') === 'mendekati' ? 'selected' : '' }}>Sortir: Mendekati Hari Ini</option>
        </select>

        <button type="submit"
                class="px-6 py-3 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm">
            Cari
        </button>
        <a href="{{ route('admin.jadwal-sistem', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
           class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">
            Reset
        </a>
    </form>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">ID</th>
                    <th class="px-6 py-5">Tanggal</th>
                    <th class="px-6 py-5">Tipe</th>
                    <th class="px-6 py-5">Jam Operasional</th>
                    <th class="px-6 py-5">Keterangan</th>
                    <th class="px-6 py-5 text-center">Kelola</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                @forelse($jadwalKhusus as $jk)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 text-slate-400 text-[13px] font-mono">#{{ $jk->id }}</td>
                    <td class="px-6 py-5 tabular-nums">
                        {{ \Carbon\Carbon::parse($jk->tgl_khusus)->locale('id')->isoFormat('D MMMM YYYY') }}
                    </td>
                    <td class="px-6 py-5">
                        @if($jk->is_libur)
                        <span class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-rose-600 bg-rose-50 px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Libur
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Jam Khusus
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-slate-500 text-[13px] tabular-nums">
                        @if(!$jk->is_libur && $jk->jam_buka !== null)
                            {{ $jk->jam_buka_format }} – {{ $jk->jam_tutup_format }}
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-slate-600 max-w-[220px] truncate">
                        {{ $jk->keterangan ?: '—' }}
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.jadwal-sistem.edit', $jk) }}"
                               class="px-5 py-2 rounded-full bg-gray-200 hover:bg-blue-100 hover:text-blue-700 text-slate-700 text-[13px] transition-colors shadow-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.jadwal-sistem.destroy', $jk) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus jadwal tanggal {{ \Carbon\Carbon::parse($jk->tgl_khusus)->isoFormat('D MMMM YYYY') }}? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="px-5 py-2 rounded-full bg-gray-200 hover:bg-rose-100 hover:text-rose-700 text-slate-700 text-[13px] transition-colors shadow-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-14 text-center text-slate-400 text-[14px]">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Belum ada tanggal libur atau jadwal khusus.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="p-6 border-t border-gray-100 flex items-center justify-between gap-4 bg-gray-200/50 rounded-b-[24px]">
            <span class="text-[14px] text-slate-500">
                Menampilkan {{ $jadwalKhusus->firstItem() ?? 0 }} – {{ $jadwalKhusus->lastItem() ?? 0 }}
                dari {{ $jadwalKhusus->total() }} jadwal
            </span>
            <div class="text-[14px] font-bold text-slate-600">
                {{ $jadwalKhusus->links() }}
            </div>
        </div>
    </div>

</div>{{-- end blok 2 --}}
</div>{{-- end space-y --}}

@push('scripts')
<script>
function kalenderNav(delta) {
    let b = parseInt(document.getElementById('inputBulan').value);
    let t = parseInt(document.getElementById('inputTahun').value);
    b += delta;
    if (b < 1)  { b = 12; t--; }
    if (b > 12) { b = 1;  t++; }
    document.getElementById('inputBulan').value = b;
    document.getElementById('inputTahun').value = t;
    document.getElementById('formKalender').submit();
}
</script>
@endpush

@endsection