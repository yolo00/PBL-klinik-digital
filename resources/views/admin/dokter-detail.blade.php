@extends('admin.layouts.app')
@section('title', 'Detail Dokter')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Detail Dokter</h2>
                <p class="text-[14px] text-slate-500 mt-1">ID Dokter #{{ $dokter->id_dokter }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.dokter.edit', $dokter->id_dokter) }}"
                    class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors">Edit</a>
                <a href="{{ route('admin.dokter.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">Kembali</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-admin.detail-card label="Nama Dokter"    :value="$dokter->user->nama ?? '—'" />
            <x-admin.detail-card label="Email"          :value="$dokter->user->email ?? '—'" />
            <x-admin.detail-card label="Spesialis"      :value="$dokter->spesialis" />
            <x-admin.detail-card label="Nomor HP"       :value="$dokter->user->no_hp ?? '—'" />
            <x-admin.detail-card label="Jenis Kelamin"  :value="$dokter->user->jenis_kelamin_label ?? '—'" />
            <x-admin.detail-card label="Tanggal Lahir"  :value="$dokter->user->tgl_lahir ? \Carbon\Carbon::parse($dokter->user->tgl_lahir)->format('d M Y') : '—'" />
            <x-admin.detail-card label="Total Jadwal"   :value="$dokter->jadwals->count() . ' jadwal'" />
            <x-admin.detail-card label="Total Cuti"     :value="$dokter->cutiDokters->count() . ' pengajuan'" />
        </div>
    </div>

    {{-- Riwayat Jadwal --}}
    @if($dokter->jadwals->isNotEmpty())
    <div class="bg-gray-200/50 rounded-[24px] p-6">
        <h3 class="text-[16px] font-bold text-slate-800 mb-4">Jadwal Terbaru</h3>
        <div class="overflow-x-auto bg-white rounded-[18px] shadow-sm border border-slate-100 px-2 py-2">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[13px] text-slate-600 font-medium border-b border-gray-100">
                        <th class="px-5 py-4">Pasien</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Jam</th>
                        <th class="px-5 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="text-[13px] text-slate-800 divide-y divide-gray-100">
                    @foreach($dokter->jadwals->take(10) as $jadwal)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4">{{ $jadwal->pasien?->user?->nama ?? '—' }}</td>
                        <td class="px-5 py-4">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                        <td class="px-5 py-4">{{ \Illuminate\Support\Str::substr($jadwal->jam, 0, 5) }}</td>
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
