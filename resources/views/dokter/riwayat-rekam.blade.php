@extends('dokter.layouts.dokter')
@section('title', 'Semua Rekam Medis')

@section('content')
<div class="mb-8">
    <h1 class="text-[30px] font-black text-slate-800 leading-tight">Rekam Medis</h1>
    <p class="text-slate-400 font-medium mt-1">Seluruh rekam medis pasien yang pernah Anda tangani.</p>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[11px] font-black text-slate-400 uppercase tracking-[2px]">
                    <th class="px-8 py-6">ID</th>
                    <th class="px-8 py-6">Nama Pasien</th>
                    <th class="px-8 py-6">Tanggal</th>
                    <th class="px-8 py-6">Diagnosa</th>
                    <th class="px-8 py-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($rekamMedis as $rm)
                <tr class="hover:bg-slate-50/80 transition-all">
                    <td class="px-8 py-6 text-slate-400 font-medium">#{{ $rm->id }}</td>
                    <td class="px-8 py-6">
                        <span class="font-bold text-slate-800">
                            {{ $rm->jadwal->pasien->user->nama ?? 'Pasien Tidak Ditemukan' }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-slate-600 font-medium">
                        {{ $rm->created_at ? $rm->created_at->format('d F Y') : '-' }}
                    </td>
                    <td class="px-8 py-6 text-slate-600 font-medium max-w-xs">
                        {{ \Illuminate\Support\Str::limit($rm->diagnosa ?? '-', 50) }}
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('dokter.rekam.show', $rm->id) }}"
                               class="px-5 py-2 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase hover:bg-slate-200 transition-all">
                                <i class="fa-solid fa-eye mr-1"></i> Lihat
                            </a>
                            <a href="{{ route('dokter.rekam.export-pdf', $rm->id) }}"
                               class="px-5 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase hover:bg-emerald-100 transition-all">
                                <i class="fa-solid fa-file-pdf mr-1"></i> PDF
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium">
                        Belum ada rekam medis.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection