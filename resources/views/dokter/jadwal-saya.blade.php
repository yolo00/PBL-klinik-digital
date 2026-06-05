@extends('dokter.layouts.dokter')

@section('title', 'Jadwal Saya')

@section('content')
<div class="mb-8">
    <h1 class="text-[30px] font-black text-slate-800 leading-tight">Jadwal Pasien</h1>
    <p class="text-slate-400 font-medium mt-1">Daftar pemeriksaan pasien untuk hari ini.</p>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[11px] font-black text-slate-400 uppercase tracking-[2px]">
                    <th class="px-8 py-6">Jam Kerja</th>
                    <th class="px-8 py-6">Nama Pasien</th> <th class="px-8 py-6">Status Jadwal</th>
                    <th class="px-8 py-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($jadwals as $jadwal)
                <tr class="hover:bg-slate-50/80 transition-all">
                    <td class="px-8 py-6">
                        <span class="text-sm font-black text-slate-800">{{ $jadwal->jam }}:00 WIB</span>
                    </td>
                    
                    <td class="px-8 py-6">
                    <span class="text-sm font-bold text-slate-800">
                        {{ $jadwal->pasien->user->nama ?? 'Nama Tidak Ditemukan' }}
                    </span>
                    </td>

                    <td class="px-8 py-6">
                        @if(($jadwal->status ?? 'menunggu') == 'menunggu')
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                Menunggu
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                                Selesai
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center">
                            @if(($jadwal->status ?? 'menunggu') == 'menunggu')
                                <a href="{{ route('dokter.jadwal.buat-rekam', $jadwal->id) }}" class="px-4 py-2 bg-emerald-500 text-white rounded-xl text-xs font-bold hover:bg-emerald-600 transition-all shadow-sm">
                                    BUAT REKAM MEDIS
                                </a>
                            @else
                                <span class="text-slate-400 text-xs font-medium bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                    Pemeriksaan Selesai
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-medium">
                        Tidak ada jadwal pemeriksaan untuk hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection