@extends('dokter.layouts.dokter')
@section('title', 'Pasien Saya')

@section('content')
<div class="mb-8">
    <h1 class="text-[30px] font-black text-slate-800 leading-tight">Pasien Saya</h1>
    <p class="text-slate-400 font-medium mt-1">Seluruh pasien yang pernah berkonsultasi dengan Anda.</p>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[11px] font-black text-slate-400 uppercase tracking-[2px]">
                    <th class="px-8 py-6">Nama Pasien</th>
                    <th class="px-8 py-6">Jenis Kelamin</th>
                    <th class="px-8 py-6">No. Telepon</th>
                    <th class="px-8 py-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pasiens as $pasien)
                <tr class="hover:bg-slate-50/80 transition-all">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user text-emerald-400 text-xs"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-800">
                                {{ $pasien->user->nama ?? 'Nama Tidak Ditemukan' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-sm font-medium text-slate-600">
                        {{ $pasien->user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>
                    <td class="px-8 py-6 text-sm font-medium text-slate-600">
                        {{ $pasien->user->no_hp ?? '-' }}
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center">
                            <a href="{{ route('dokter.rekam.riwayat', $pasien->id) }}"
                               class="px-5 py-2 bg-emerald-500 text-white rounded-xl text-xs font-bold hover:bg-emerald-600 transition-all shadow-sm">
                                <i class="fa-solid fa-notes-medical mr-1.5"></i>Lihat Riwayat
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-medium">
                        Belum ada pasien yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection