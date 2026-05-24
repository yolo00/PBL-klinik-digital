@extends('admin.layouts.app')
@section('title', 'Detail Pasien')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Detail Pasien</h2>
                <p class="text-[14px] text-slate-500 mt-1">ID Pasien #{{ $pasien->id }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.pasien.edit', $pasien->id) }}"
                    class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors">Edit</a>
                <a href="{{ route('admin.pasien.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">Kembali</a>
            </div>
        </div>

        {{-- Info Utama --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-admin.detail-card label="Nama Lengkap"    :value="$pasien->user->nama ?? '—'" />
            <x-admin.detail-card label="Email"           :value="$pasien->user->email ?? '—'" />
            <x-admin.detail-card label="Nomor HP"        :value="$pasien->user->no_hp ?? '—'" />
            <x-admin.detail-card label="Jenis Kelamin"   :value="$pasien->user->jenis_kelamin_label ?? '—'" />
            <x-admin.detail-card label="Tanggal Lahir"   :value="$pasien->user->tgl_lahir ? \Carbon\Carbon::parse($pasien->user->tgl_lahir)->format('d M Y') : '—'" />
            <x-admin.detail-card label="Golongan Darah"  :value="$pasien->gol_darah ?? '—'" />
            <x-admin.detail-card label="Terdaftar Sejak" :value="$pasien->user->created_at ? \Carbon\Carbon::parse($pasien->user->created_at)->format('d M Y, H:i') : '—'" />
            <x-admin.detail-card label="Total Jadwal"    :value="$pasien->jadwals->count() . ' jadwal'" />
        </div>

        {{-- Riwayat Penyakit --}}
        @if($pasien->riwayat_penyakit)
        <div class="mt-6 p-5 bg-amber-50 border border-amber-100 rounded-[16px]">
            <p class="text-[13px] font-bold text-amber-700 mb-1 uppercase tracking-wide">Riwayat Penyakit</p>
            <p class="text-[14px] text-slate-700">{{ $pasien->riwayat_penyakit }}</p>
        </div>
        @endif

        {{-- Daftar Alergi --}}
        @if($pasien->alergi->isNotEmpty())
        <div class="mt-6">
            <p class="text-[13px] font-bold text-slate-600 mb-2 uppercase tracking-wide">Alergi</p>
            <div class="flex flex-wrap gap-2">
                @foreach($pasien->alergi as $a)
                <span class="px-3 py-1.5 bg-rose-50 border border-rose-200 text-rose-700 text-[13px] font-semibold rounded-full">
                    {{ $a->nama_alergi }}
                </span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Riwayat Jadwal --}}
    @if($pasien->jadwals->isNotEmpty())
    <div class="bg-gray-200/50 rounded-[24px] p-6">
        <h3 class="text-[16px] font-bold text-slate-800 mb-4">Riwayat Jadwal</h3>
        <div class="overflow-x-auto bg-white rounded-[18px] shadow-sm border border-slate-100 px-2 py-2">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[13px] text-slate-600 font-medium border-b border-gray-100">
                        <th class="px-5 py-4">Dokter</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Jam</th>
                        <th class="px-5 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="text-[13px] text-slate-800 divide-y divide-gray-100">
                    @foreach($pasien->jadwals as $jadwal)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4">{{ $jadwal->dokter->dr_name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                        <td class="px-5 py-4">{{ $jadwal->jam_format }}</td>
                        <td class="px-5 py-4 font-bold {{ $jadwal->status_color }}">{{ $jadwal->status_label }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
