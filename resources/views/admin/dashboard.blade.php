@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="space-y-6 max-w-[1400px] mx-auto">

    {{-- ── Statistic Cards ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gray-200/50 rounded-2xl p-6 border border-slate-100 flex flex-col items-center justify-center gap-3 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <p class="text-[14px] text-slate-500 font-medium">Total Pasien</p>
            <p class="text-[36px] font-bold text-slate-800">{{ $totalPasien }}</p>
        </div>

        <div class="bg-gray-200/50 rounded-2xl p-6 border border-slate-100 flex flex-col items-center justify-center gap-3 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <p class="text-[14px] text-slate-500 font-medium">Total Dokter Aktif</p>
            <p class="text-[36px] font-bold text-slate-800">{{ $totalDokter }}</p>
        </div>

        <div class="bg-gray-200/50 rounded-2xl p-6 border border-slate-100 flex flex-col items-center justify-center gap-3 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <p class="text-[14px] text-slate-500 font-medium">Jadwal Hari Ini</p>
            <p class="text-[36px] font-bold text-slate-800">{{ $totalJadwalHariIni }}</p>
        </div>

        <div class="bg-gray-200/50 rounded-2xl p-6 border border-slate-100 flex flex-col items-center justify-center gap-3 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <p class="text-[14px] text-slate-500 font-medium">Rekam Medis Baru (7 Hari)</p>
            <p class="text-[36px] font-bold text-slate-800">{{ $totalRekamMedis7Hari }}</p>
        </div>
    </div>

    {{--  Grafik Jadwal--}}
    <div class="bg-gray-200/50 rounded-[32px] p-8 border border-slate-100">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Grafik Jadwal</h2>
                <p class="text-[13px] text-slate-500 mt-0.5">
                    {{ now()->subDays($range)->translatedFormat('d M Y') }}
                    &ndash;
                    {{ now()->addDays($range)->translatedFormat('d M Y') }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                @foreach([1, 3, 7] as $r)
                    <a href="{{ request()->fullUrlWithQuery(['range' => $r]) }}"
                       class="px-4 py-1.5 rounded-full text-[13px] font-semibold transition-colors
                              {{ $range == $r
                                  ? 'bg-blue-600 text-white shadow-sm'
                                  : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                        ±{{ $r }} hari
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-5 mb-4 text-[13px] text-slate-500">
            <span class="flex items-center gap-1.5">
                <span class="inline-block w-3 h-3 rounded-sm bg-slate-400"></span> Sudah lewat
            </span>
            <span class="flex items-center gap-1.5">
                <span class="inline-block w-3 h-3 rounded-sm bg-blue-500"></span> Mendatang / Hari ini
            </span>
        </div>

        {{-- Chart --}}
        <div class="bg-white rounded-[20px] border border-slate-100 p-4">
            <canvas id="jadwalChart" height="90"></canvas>
        </div>
    </div>

    {{-- ── Tabel Jadwal Hari Ini & Dokter Cuti (1 row) ──────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Jadwal Hari Ini --}}
        <x-ui:card class="bg-gray-200/50 rounded-[32px] p-6 border-slate-100">
            <h2 class="text-[18px] font-bold text-slate-800 mb-4 flex items-center gap-3">
                Jadwal Hari Ini
                <span class="text-[13px] font-semibold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">
                    {{ $jadwalHariIni->count() }} jadwal
                </span>
            </h2>

            <x-ui:data-table class="bg-white rounded-[20px] shadow-sm border border-slate-100">
                <thead class="sr-only"></thead>
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[13px] text-slate-500 font-medium border-b border-gray-100">
                            <th class="px-5 py-4">Pasien</th>
                            <th class="px-5 py-4">Dokter</th>
                            <th class="px-5 py-4">Jam</th>
                            <th class="px-5 py-4">Status</th>
                        </tr>
                    </thead>

                    <tbody class="text-[13px] text-slate-800 font-medium divide-y divide-gray-100">
                        @forelse($jadwalHariIni as $jadwal)
                            <tr class="hover:bg-blue-50/40 transition-colors cursor-pointer"
                                onclick="window.location='{{ route('admin.jadwal.show', $jadwal->id) }}'">
                                <td class="px-5 py-4 align-middle">
                                    {{ $jadwal->pasien?->user?->nama ?? '-' }}
                                </td>
                                <td class="px-5 py-4 align-middle text-slate-500">
                                    @php
                                        $namaLengkap = $jadwal->dokter?->user?->nama ?? '';
                                        $namaDisplay = $namaLengkap
                                            ? 'dr. ' . $namaLengkap
                                            : '-';
                                    @endphp
                                    {{ $namaDisplay }}
                                </td>
                                <td class="px-5 py-4 align-middle text-slate-500">
                                    {{ sprintf('%02d:00', $jadwal->jam) }}
                                </td>
                                <td class="px-5 py-4 align-middle">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[12px] font-semibold {{ $jadwal->status_badge }}">
                                        {{ $jadwal->status_label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-slate-400 text-[13px]">
                                    Tidak ada jadwal hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-ui:data-table>
        </x-ui:card>

        {{-- Dokter Cuti Hari Ini --}}
        <x-ui:card class="bg-gray-200/50 rounded-[32px] p-6 border-slate-100">
            <h2 class="text-[18px] font-bold text-slate-800 mb-4 flex items-center gap-3">
                Dokter Cuti Hari Ini
                @if($dokterCutiHariIni->isNotEmpty())
                    <span class="text-[13px] font-semibold text-amber-600 bg-amber-50 px-2.5 py-0.5 rounded-full">
                        {{ $dokterCutiHariIni->count() }} dokter
                    </span>
                @endif
            </h2>

            <x-ui:data-table class="bg-white rounded-[20px] shadow-sm border border-slate-100">
                <thead class="sr-only"></thead>
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[13px] text-slate-500 font-medium border-b border-gray-100">
                            <th class="px-5 py-4">Nama Dokter</th>
                            <th class="px-5 py-4">Tanggal Cuti</th>
                        </tr>
                    </thead>

                    <tbody class="text-[13px] text-slate-800 font-medium divide-y divide-gray-100">
                        @forelse($dokterCutiHariIni as $cuti)
                            <tr class="hover:bg-amber-50/40 transition-colors">
                                <td class="px-5 py-4 align-middle">
                                    {{ $cuti->dokter?->user?->nama ?? '-' }}
                                </td>
                                <td class="px-5 py-4 align-middle text-slate-500">
                                    {{ $cuti->dari_tanggal->translatedFormat('d M Y') }}
                                    &ndash;
                                    {{ $cuti->sampai_tanggal->translatedFormat('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-5 py-10 text-center text-slate-400 text-[13px]">
                                    Tidak ada dokter yang cuti hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-ui:data-table>
        </x-ui:card>

    </div>{{-- end row --}}

</div>

{{-- ── Chart.js ─────────────────────────────────────────────── --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('jadwalChart').getContext('2d');

    const labels = @json($chartLabels);
    const data   = @json($chartData);
    const colors = @json($chartColors);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Jadwal',
                data: data,
                backgroundColor: colors,
                borderRadius: 8,
                borderSkipped: false,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} jadwal`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 12 } }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 12 },
                        stepSize: 1,
                        precision: 0
                    },
                    grid: { color: '#f1f5f9' }
                }
            }
        }
    });
</script>
@endpush
@endsection
