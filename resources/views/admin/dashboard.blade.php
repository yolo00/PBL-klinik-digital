@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="space-y-6 max-w-[1400px] mx-auto">
    <!-- Statistic Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gray-200/50 rounded-[28px] p-6 border border-slate-100 flex flex-col items-center justify-center gap-3">
            <p class="text-[14px] text-slate-500 font-medium">Total Pasien</p>
            <p class="text-[36px] font-bold text-slate-800">{{ $totalPasien }}</p>
        </div>
        <div class="bg-gray-200/50 rounded-[28px] p-6 border border-slate-100 flex flex-col items-center justify-center gap-3">
            <p class="text-[14px] text-slate-500 font-medium">Total Dokter Aktif</p>
            <p class="text-[36px] font-bold text-slate-800">{{ $totalDokter }}</p>
        </div>
        <div class="bg-gray-200/50 rounded-[28px] p-6 border border-slate-100 flex flex-col items-center justify-center gap-3">
            <p class="text-[14px] text-slate-500 font-medium">Jadwal Hari Ini</p>
            <p class="text-[36px] font-bold text-slate-800">{{ $totalJadwalHariIni }}</p>
        </div>
        <div class="bg-gray-200/50 rounded-[28px] p-6 border border-slate-100 flex flex-col items-center justify-center gap-3">
            <p class="text-[14px] text-slate-500 font-medium">Rekam Medis Baru (7 Hari)</p>
            <p class="text-[36px] font-bold text-slate-800">{{ $totalRekamMedis7Hari }}</p>
        </div>
    </div>

    <!-- Dokter Cuti Hari Ini -->
    @if($dokterCutiHariIni->isNotEmpty())
    <div class="bg-amber-50 border border-amber-200 rounded-[20px] px-6 py-4 flex items-center gap-4">
        <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        <div>
            <p class="text-[14px] font-bold text-amber-800">Dokter Cuti Hari Ini</p>
            <p class="text-[13px] text-amber-700">
                {{ $dokterCutiHariIni->map(fn($c) => $c->dokter->dr_name)->join(', ') }}
            </p>
        </div>
    </div>
    @endif

    <!-- Jadwal Terbaru -->
    <div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8 mt-6">
        <h2 class="text-[20px] font-bold text-slate-800 mb-6">Jadwal Terbaru</h2>
        <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                        <th class="px-6 py-5">Pasien</th>
                        <th class="px-6 py-5">Dokter</th>
                        <th class="px-6 py-5">Tanggal</th>
                        <th class="px-6 py-5">Jam</th>
                        <th class="px-6 py-5">Status</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                    @forelse($jadwalTerbaru as $jadwal)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5 align-middle">
                            {{ $jadwal->pasien?->user?->nama ?? '-' }}
                        </td>
                        <td class="px-6 py-5 align-middle">
                            {{ $jadwal->dokter->dr_name }}
                        </td>
                        <td class="px-6 py-5 align-middle text-slate-500">
                            {{ $jadwal->tanggal->format('d M Y') }}
                        </td>
                        <td class="px-6 py-5 align-middle text-slate-500">
                            {{ \Illuminate\Support\Str::substr($jadwal->jam, 0, 5) }}
                        </td>
                        <td class="px-6 py-5 align-middle font-bold {{ $jadwal->status_color }}">
                            {{ $jadwal->status_label }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-[14px]">Belum ada jadwal tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
