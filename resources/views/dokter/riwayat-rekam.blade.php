@extends('dokter.layouts.dokter')
@section('title', 'Semua Rekam Medis')
@section('breadcrumb', 'Rekam Medis — Semua Catatan')

@section('content')
<div class="mb-7">
    <h1 class="text-2xl font-bold text-slate-800">Rekam Medis</h1>
    <p class="text-slate-500 text-sm mt-1">Seluruh rekam medis pasien yang pernah Anda tangani.</p>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">ID</th>
                    <th class="text-left">Nama Pasien</th>
                    <th class="text-left">Tanggal</th>
                    <th class="text-left">Diagnosa</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekamMedis as $rm)
                <tr>
                    <td class="text-slate-400 font-medium">#{{ $rm->id }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user text-blue-400 text-xs"></i>
                            </div>
                            <span class="font-semibold text-slate-800">
                                {{ $rm->jadwal->pasien->user->nama ?? 'Pasien Tidak Ditemukan' }}
                            </span>
                        </div>
                    </td>
                    <td class="text-slate-500 text-sm">
                        {{ $rm->created_at ? $rm->created_at->format('d F Y') : '-' }}
                    </td>
                    <td class="text-slate-600 max-w-xs">
                        {{ \Illuminate\Support\Str::limit($rm->diagnosa ?? '-', 50) }}
                    </td>
                    <td class="text-center">
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
                    <td colspan="5" class="py-14 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fa-solid fa-folder-open text-4xl text-slate-200"></i>
                            <p class="text-sm font-medium text-slate-400">Belum ada rekam medis.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
