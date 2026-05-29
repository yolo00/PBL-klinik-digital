@extends('admin.layouts.app')
@section('title', 'Detail Rekam Medis')
@section('content')

<div class="space-y-6">

    {{-- Flash message --}}
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-[16px] text-[13px] text-emerald-700 flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="p-4 bg-rose-50 border border-rose-200 rounded-[16px] text-[13px] text-rose-700 flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Header + action --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">

        <div class="flex flex-wrap items-start justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Detail Rekam Medis</h2>
                <p class="text-[14px] text-slate-500 mt-1">ID Rekam #{{ $rekamMedis->id }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.rekam-medis.edit', $rekamMedis->id) }}"
                    class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors">
                    Edit
                </a>
                <form action="{{ route('admin.rekam-medis.destroy', $rekamMedis->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus rekam medis ini? Semua resep terkait juga akan dihapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2.5 bg-rose-50 text-rose-600 font-medium rounded-[12px] text-[14px] hover:bg-rose-100 transition-colors border border-rose-200">
                        Hapus
                    </button>
                </form>
                <a href="{{ route('admin.rekam-medis.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">
                    Kembali
                </a>
            </div>
        </div>

        {{-- ══ Informasi Jadwal ══ --}}
        <div class="mb-8">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Jadwal</p>
            <div class="bg-slate-50 rounded-[16px] border border-slate-100 p-5 grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Jadwal --}}
                <div class="space-y-1">
                    <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Jadwal</p>
                    <p class="text-[15px] font-semibold text-slate-800">
                        #{{ $rekamMedis->id_jadwal }}
                        · {{ $rekamMedis->jadwal?->tanggal?->translatedFormat('d M Y') ?? '—' }}
                    </p>
                    <p class="text-[13px] text-slate-500 font-mono">
                        {{ $rekamMedis->jadwal ? sprintf('%02d:00', $rekamMedis->jadwal->jam) : '' }}
                    </p>
                    @if($rekamMedis->jadwal)
                    <a href="{{ route('admin.jadwal.show', $rekamMedis->jadwal->id) }}"
                        class="inline-block text-[12px] text-slate-400 hover:text-slate-600 underline transition-colors mt-1">
                        Lihat detail jadwal →
                    </a>
                    @endif
                </div>

                {{-- Pasien --}}
                <div class="space-y-1">
                    <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Pasien</p>
                    @if($rekamMedis->jadwal?->pasien?->user)
                        <p class="text-[15px] font-semibold text-slate-800">
                            {{ $rekamMedis->jadwal->pasien->user->nama }}
                        </p>
                        <p class="text-[13px] text-slate-500">
                            ID Pasien #{{ $rekamMedis->jadwal->pasien->id }}
                        </p>
                        @if($rekamMedis->jadwal->pasien->user->no_hp)
                        <p class="text-[13px] text-slate-500">
                            {{ $rekamMedis->jadwal->pasien->user->no_hp }}
                        </p>
                        @endif
                    @else
                        <p class="text-[15px] text-slate-400 italic">Tanpa Pasien</p>
                    @endif
                </div>

                {{-- Dokter --}}
                <div class="space-y-1">
                    <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Dokter Pemeriksa</p>
                    <p class="text-[15px] font-semibold text-slate-800">
                        {{ $rekamMedis->jadwal?->dokter?->user?->nama ?? '—' }}
                    </p>
                    <p class="text-[13px] text-slate-500">
                        {{ $rekamMedis->jadwal?->dokter?->spesialisasi?->nama ?? '' }}
                    </p>
                    @if($rekamMedis->jadwal?->dokter)
                    <p class="text-[13px] text-slate-400">
                        ID Dokter #{{ $rekamMedis->jadwal->dokter->id }}
                    </p>
                    @endif
                </div>

            </div>
        </div>

        {{-- ══ Rekam Medis ══ --}}
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4">Catatan Medis</p>
            <div class="grid grid-cols-1 gap-5">

                <div class="space-y-1">
                    <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Keluhan</p>
                    <p class="text-[14px] text-slate-700 leading-relaxed">{{ $rekamMedis->keluhan ?? '—' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Diagnosa</p>
                    <p class="text-[14px] text-slate-700 leading-relaxed">{{ $rekamMedis->diagnosa ?? '—' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Catatan Tambahan</p>
                    <p class="text-[14px] text-slate-700 leading-relaxed">{{ $rekamMedis->catatan ?? '—' }}</p>
                </div>

            </div>
        </div>

        {{-- ══ Meta ══ --}}
        <div class="mt-8 pt-5 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Dibuat oleh</p>
                <p class="text-[13px] text-slate-600">
                    {{ $rekamMedis->createdBy?->nama ?? '—' }}
                    @if($rekamMedis->created_at)
                        · {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d M Y, H:i') }}
                    @endif
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Terakhir diubah oleh</p>
                <p class="text-[13px] text-slate-600">
                    @if($rekamMedis->updatedBy)
                        {{ $rekamMedis->updatedBy->nama }}
                        @if($rekamMedis->updated_at)
                            · {{ \Carbon\Carbon::parse($rekamMedis->updated_at)->format('d M Y, H:i') }}
                        @endif
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>

    </div>

    {{-- ══ Resep terkait ══ --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
            <h3 class="text-[16px] font-bold text-slate-800">
                Resep
                @if($rekamMedis->reseps->isNotEmpty())
                <span class="ml-2 px-2 py-0.5 bg-slate-100 text-slate-500 text-[12px] font-medium rounded-full">
                    {{ $rekamMedis->reseps->count() }}
                </span>
                @endif
            </h3>
        </div>

        @if($rekamMedis->reseps->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[14px]">
                <thead>
                    <tr class="text-slate-500 font-medium border-b border-slate-100">
                        <th class="pb-3 pr-6">Obat</th>
                        <th class="pb-3 pr-6">Dosis</th>
                        <th class="pb-3">Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($rekamMedis->reseps as $resep)
                    <tr>
                        <td class="py-3 pr-6 font-semibold text-slate-800">{{ $resep->obat }}</td>
                        <td class="py-3 pr-6 text-slate-600">{{ $resep->dosis ?? '—' }}</td>
                        <td class="py-3 text-slate-600">{{ $resep->aturan_pakai ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-[14px] text-slate-400 italic">Tidak ada resep untuk rekam medis ini.</p>
        @endif
    </div>

</div>
@endsection