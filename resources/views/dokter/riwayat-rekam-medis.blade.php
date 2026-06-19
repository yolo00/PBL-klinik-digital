@extends('dokter.layouts.dokter')
@section('title', 'Riwayat Rekam Medis')
@section('breadcrumb', 'Pasien — Riwayat Rekam Medis')

@section('content')
{{-- Back + Title --}}
<div class="flex items-center gap-4 mb-7">
    <a href="{{ route('dokter.pasien') }}"
       class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
        <i class="fa-solid fa-arrow-left text-sm"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Rekam Medis</h1>
        <p class="text-slate-500 text-sm mt-0.5">
            Seluruh log rekam medis <span class="font-semibold text-blue-600">{{ $pasien->user->nama ?? 'Pasien' }}</span> di UniHealth.
        </p>
    </div>
</div>

{{-- Profil Pasien Card --}}
<div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl p-6 mb-6 flex flex-col md:flex-row justify-between gap-5 shadow-lg">
    <div class="space-y-3">
        <span class="px-3 py-1 bg-blue-500 text-white rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">
            Profil Pasien
        </span>
        <h2 class="text-xl font-bold text-white">{{ $pasien->user->nama ?? 'Nama Tidak Ditemukan' }}</h2>
        <div class="flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-300">
            <span><i class="fa-solid fa-venus-mars mr-1.5 text-purple-400"></i>
                {{ $pasien->user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
            </span>
            <span><i class="fa-solid fa-phone mr-1.5 text-blue-400"></i>{{ $pasien->user->no_hp ?? '-' }}</span>
            <span><i class="fa-solid fa-droplet mr-1.5 text-red-400"></i>Gol. Darah: {{ $pasien->gol_darah ?? '-' }}</span>
        </div>
    </div>
    <div class="flex items-center bg-white/10 border border-white/10 px-6 py-4 rounded-xl self-start md:self-center">
        <div class="text-center">
            <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Total Kunjungan</p>
            <p class="text-3xl font-bold text-blue-400 mt-0.5">
                {{ $rekamMedis->count() }}
                <span class="text-sm font-medium text-slate-400">Rekam</span>
            </p>
        </div>
    </div>
</div>

{{-- Tabel Riwayat --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">ID Rekam</th>
                    <th class="text-left">Tanggal Kunjungan</th>
                    <th class="text-left">Diagnosa</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekamMedis as $rm)
                <tr>
                    <td class="text-slate-400 font-medium">#{{ $rm->id }}</td>
                    <td class="font-semibold text-slate-700">
                        {{ $rm->created_at ? $rm->created_at->format('d F Y') : '-' }}
                    </td>
                    <td class="text-slate-600 max-w-xs">
                        {{ \Illuminate\Support\Str::limit($rm->diagnosa ?? '-', 50) }}
                    </td>
                    <td>
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('dokter.rekam.show', $rm->id) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition-all">
                                <i class="fa-solid fa-eye text-[10px]"></i> Lihat
                            </a>
                            <a href="{{ route('dokter.rekam.export-pdf', $rm->id) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-all">
                                <i class="fa-solid fa-file-pdf text-[10px]"></i> PDF
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fa-solid fa-folder-open text-4xl text-slate-200"></i>
                            <p class="text-sm font-medium text-slate-400">Belum ada riwayat rekam medis untuk pasien ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
