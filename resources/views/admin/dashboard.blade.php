@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')
@section('content')

<div class="space-y-8 max-w-[1400px]">
    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <x-admin.stat-card
            label="Total Pasien"
            :value="$totalPasien"
            color="blue"
            icon="<i class='fa-solid fa-users text-blue-600 text-lg'></i>"
        />
        
        <x-admin.stat-card
            label="Total Dokter Aktif"
            :value="$totalDokter"
            color="emerald"
            icon="<i class='fa-solid fa-user-doctor text-emerald-600 text-lg'></i>"
        />
        
        <x-admin.stat-card
            label="Jadwal Hari Ini"
            :value="$totalJadwalHariIni"
            color="amber"
            icon="<i class='fa-solid fa-calendar-day text-amber-600 text-lg'></i>"
        />
        
        <x-admin.stat-card
            label="Rekam Medis (7 Hari)"
            :value="$totalRekamMedis7Hari"
            color="rose"
            icon="<i class='fa-solid fa-file-waveform text-rose-600 text-lg'></i>"
        />
    </div>

    <!-- Chart Section -->
    <x-admin.section-card title="Grafik Jadwal" subtitle="Visualisasi jadwal dalam rentang waktu">
        <div class="space-y-4">
            <!-- Date Range Filters -->
            <div class="flex flex-col sm:flex-row gap-2">
                @foreach([1, 3, 7] as $r)
                    <a 
                        href="{{ request()->fullUrlWithQuery(['range' => $r]) }}"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $range == $r ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                    >
                        ±{{ $r }} hari
                    </a>
                @endforeach
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap gap-4 text-xs md:text-sm text-slate-600 pb-4">
                <span class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-slate-400"></span> Sudah lewat
                </span>
                <span class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-blue-500"></span> Mendatang / Hari ini
                </span>
            </div>

            <!-- Chart Canvas -->
            <div class="bg-white rounded-lg p-4 border border-slate-100 overflow-x-auto">
                <canvas id="jadwalChart" height="70"></canvas>
            </div>
        </div>
    </x-admin.section-card>

    <!-- Tables Section - Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Jadwal Hari Ini -->
        <x-admin.section-card title="Jadwal Hari Ini" :badge="$jadwalHariIni->count()" badgeType="blue">
            <x-admin.table-wrapper :pagination="$jadwalHariIni" :totalItems="$jadwalHariIni->count()" itemLabel="jadwal">
                <thead>
                    <tr class="text-xs md:text-sm text-slate-600 font-semibold border-b border-slate-100 bg-slate-50">
                        <th class="px-4 md:px-6 py-3 text-left">Pasien</th>
                        <th class="px-4 md:px-6 py-3 text-left hidden sm:table-cell">Dokter</th>
                        <th class="px-4 md:px-6 py-3 text-left">Jam</th>
                        <th class="px-4 md:px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jadwalHariIni as $jadwal)
                        <tr class="hover:bg-blue-50/50 transition-colors cursor-pointer text-xs md:text-sm" 
                            onclick="window.location='{{ route('admin.jadwal.show', $jadwal->id) }}'">
                            <td class="px-4 md:px-6 py-4 text-slate-800 font-medium">
                                <span class="line-clamp-1">{{ $jadwal->pasien?->user?->nama ?? '-' }}</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-slate-600 hidden sm:table-cell">
                                {{ $jadwal->dokter?->user?->nama ? 'dr. ' . $jadwal->dokter->user->nama : '-' }}
                            </td>
                            <td class="px-4 md:px-6 py-4 text-slate-600">
                                {{ sprintf('%02d:00', $jadwal->jam) }}
                            </td>
                            <td class="px-4 md:px-6 py-4 text-center">
                                <x-admin.badge :type="str_replace(['bg-', 'text-'], '', explode(' ', $jadwal->status_badge)[0] ?? 'slate')" :text="$jadwal->status_label" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 md:px-6 py-8 text-center text-slate-400 text-sm">
                                Tidak ada jadwal hari ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-admin.table-wrapper>
        </x-admin.section-card>

        <!-- Dokter Cuti Hari Ini -->
        <x-admin.section-card 
            title="Dokter Cuti Hari Ini" 
            :badge="$dokterCutiHariIni->isNotEmpty() ? $dokterCutiHariIni->count() : null" 
            badgeType="amber"
        >
            <x-admin.table-wrapper :pagination="$dokterCutiHariIni" :totalItems="$dokterCutiHariIni->count()" itemLabel="dokter">
                <thead>
                    <tr class="text-xs md:text-sm text-slate-600 font-semibold border-b border-slate-100 bg-slate-50">
                        <th class="px-4 md:px-6 py-3 text-left">Nama Dokter</th>
                        <th class="px-4 md:px-6 py-3 text-left">Tanggal Cuti</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dokterCutiHariIni as $cuti)
                        <tr class="hover:bg-amber-50/50 transition-colors text-xs md:text-sm">
                            <td class="px-4 md:px-6 py-4 text-slate-800 font-medium">
                                <span class="line-clamp-1">{{ $cuti->dokter?->user?->nama ?? '-' }}</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-slate-600">
                                <span class="line-clamp-1">
                                    {{ $cuti->dari_tanggal->translatedFormat('d M Y') }} – {{ $cuti->sampai_tanggal->translatedFormat('d M Y') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 md:px-6 py-8 text-center text-slate-400 text-sm">
                                Tidak ada dokter yang cuti hari ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-admin.table-wrapper>
        </x-admin.section-card>
    </div>
</div>

{{-- Chart.js Script --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('jadwalChart')?.getContext('2d');
        if (!ctx) return;

        const labels = @json($chartLabels);
        const data = @json($chartData);
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
                maintainAspectRatio: true,
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
    });
</script>
@endpush

@endsection
