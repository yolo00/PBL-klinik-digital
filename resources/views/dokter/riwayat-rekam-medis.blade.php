@extends('dokter.layouts.dokter')
@section('title', 'Riwayat Rekam Medis Pasien')

@section('content')
<div class="mb-10 flex items-center gap-4">
    <a href="{{ route('dokter.pasien') }}"
       class="w-12 h-12 bg-white border border-slate-100 shadow-sm rounded-xl flex items-center justify-center text-slate-600 hover:text-emerald-600 hover:border-emerald-100 transition-all">
        <i class="fa-solid fa-arrow-left text-sm"></i>
    </a>
    <div>
        <h1 class="text-[32px] font-black text-slate-800 leading-tight">Riwayat Rekam Medis</h1>
        <p class="text-slate-400 font-medium mt-1">
            Seluruh log rekam medis <span class="font-bold text-slate-700">{{ $pasien->user->nama ?? 'Pasien' }}</span> di UniHealth.
        </p>
    </div>
</div>

{{-- Kartu Profil Pasien --}}
<div class="bg-slate-900 rounded-[30px] p-8 mb-8 text-white shadow-xl flex flex-col md:flex-row justify-between gap-6">
    <div class="space-y-2">
        <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-[9px] font-black uppercase tracking-wider">
            Profil Pasien
        </span>
        <h2 class="text-2xl font-black tracking-tight">{{ $pasien->user->nama ?? 'Nama Tidak Ditemukan' }}</h2>
        <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm font-medium text-slate-300">
            <div>
                <i class="fa-solid fa-venus-mars mr-2 text-purple-400"></i>
                {{ $pasien->user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
            </div>
            <div>
                <i class="fa-solid fa-phone mr-2 text-blue-400"></i>
                {{ $pasien->user->no_hp ?? '-' }}
            </div>
            <div>
                <i class="fa-solid fa-droplet mr-2 text-red-400"></i>
                Gol. Darah: {{ $pasien->gol_darah ?? '-' }}
            </div>
        </div>
    </div>
    <div class="flex items-center bg-slate-800/50 border border-slate-700/50 p-5 rounded-2xl self-start md:self-center">
        <div class="text-center md:text-right">
            <span class="text-xs text-slate-400 font-bold block uppercase tracking-wider">Total Kunjungan</span>
            <span class="text-3xl font-black text-emerald-400">
                {{ $rekamMedis->count() }}
                <span class="text-sm font-medium text-slate-300">Rekam Medis</span>
            </span>
        </div>
    </div>
</div>

{{-- Tabel Riwayat --}}
<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-10">
    <div class="overflow-x-auto rounded-3xl border border-slate-50">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[2px]">
                    <th class="px-8 py-5">ID Rekam</th>
                    <th class="px-8 py-5">Tanggal Kunjungan</th>
                    <th class="px-8 py-5">Diagnosa</th>
                    <th class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm font-bold divide-y divide-slate-50">
                @forelse($rekamMedis as $rm)
                <tr class="hover:bg-slate-50/80 transition-all">
                    <td class="px-8 py-6 text-slate-400 font-medium">#{{ $rm->id }}</td>
                    <td class="px-8 py-6 text-slate-800">
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
                    <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-medium">
                        Belum ada riwayat rekam medis untuk pasien ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection