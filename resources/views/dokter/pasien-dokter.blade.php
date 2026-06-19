@extends('dokter.layouts.dokter')
@section('title', 'Pasien Saya')
@section('breadcrumb', 'Pasien — Daftar Pasien Anda')

@section('content')
<div class="mb-7">
    <h1 class="text-2xl font-bold text-slate-800">Pasien Saya</h1>
    <p class="text-slate-500 text-sm mt-1">Seluruh pasien yang pernah berkonsultasi dengan Anda.</p>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">Nama Pasien</th>
                    <th class="text-left">Jenis Kelamin</th>
                    <th class="text-left">No. Telepon</th>
                    <th class="text-left">Gol. Darah</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pasiens as $pasien)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center shrink-0 border border-blue-100">
                                <i class="fa-solid fa-user text-blue-400 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $pasien->user->nama ?? '-' }}</p>
                                <p class="text-xs text-slate-400">{{ $pasien->user->email ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-slate-600">
                        {{ $pasien->user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>
                    <td class="text-slate-600">{{ $pasien->user->no_hp ?? '-' }}</td>
                    <td>
                        @if($pasien->gol_darah)
                            <span class="px-2.5 py-1 bg-red-50 text-red-500 rounded-lg text-xs font-bold border border-red-100">
                                {{ $pasien->gol_darah }}
                            </span>
                        @else
                            <span class="text-slate-300">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('dokter.rekam.riwayat', $pasien->id) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-all shadow-sm">
                            <i class="fa-solid fa-notes-medical text-[10px]"></i> Lihat Riwayat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-14 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fa-solid fa-user-slash text-4xl text-slate-200"></i>
                            <p class="text-sm font-medium text-slate-400">Belum ada pasien terdaftar.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
