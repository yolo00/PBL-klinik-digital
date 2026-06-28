@extends('admin.layouts.app')
@section('title', 'Detail Dokter')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Detail Dokter</h2>
                <p class="text-[14px] text-slate-500 mt-1">ID Dokter #{{ $dokter->id }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.dokter.edit', $dokter->id) }}"
                    class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors">Edit</a>
                <a href="{{ route('admin.dokter.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">Kembali</a>
            </div>
        </div>

        {{-- Foto Profil + Detail Dokter side-by-side --}}
        <div class="flex flex-col md:flex-row gap-6 items-start">

            {{-- Foto Profil --}}
            <div class="flex-shrink-0 flex flex-col items-center gap-3">
                @if($dokter->foto_profil)
                    <img src="{{ asset($dokter->foto_profil) }}" alt="Foto {{ $dokter->user->nama ?? 'Dokter' }}"
                        class="w-32 h-32 rounded-[16px] object-cover border-2 border-slate-200 shadow-sm">
                @else
                    <div class="w-32 h-32 rounded-[16px] bg-slate-100 border-2 border-slate-200 flex flex-col items-center justify-center shadow-sm">
                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <p class="text-[11px] text-slate-400 mt-1 font-medium">Belum ada foto</p>
                    </div>
                @endif
                <div class="text-center">
                    <p class="text-[13px] font-semibold text-slate-700">{{ $dokter->user->nama ?? '—' }}</p>
                    <p class="text-[12px] text-slate-400">{{ $dokter->spesialisasi->nama ?? '—' }}</p>
                </div>
            </div>

            {{-- Grid Detail --}}
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-admin.detail-card label="Nama Dokter"    :value="$dokter->user->nama ?? '—'" />
                <x-admin.detail-card label="Email"          :value="$dokter->user->email ?? '—'" />
                <x-admin.detail-card label="Spesialis"      :value="$dokter->spesialisasi->nama ?? '—'" />
                <x-admin.detail-card label="Nomor HP"       :value="$dokter->user->no_hp ?? '—'" />
                <x-admin.detail-card label="Jenis Kelamin"  :value="$dokter->user->jenis_kelamin_label ?? '—'" />
                <x-admin.detail-card label="Tanggal Lahir"  :value="$dokter->user->tgl_lahir ? \Carbon\Carbon::parse($dokter->user->tgl_lahir)->format('d M Y') : '—'" />
                <x-admin.detail-card label="Pendidikan"     :value="$dokter->pendidikan ?? '—'" />
                <x-admin.detail-card label="Total Jadwal"   :value="$dokter->jadwals->count() . ' jadwal'" />
                <x-admin.detail-card label="Total Cuti"     :value="$dokter->cutiDokters->count() . ' pengajuan'" />
            </div>
        </div>

        {{-- Tanda Tangan --}}
        @if($dokter->tanda_tangan)
        <div class="mt-6 p-5 bg-slate-50 border border-slate-200 rounded-[16px]">
            <p class="text-[13px] font-bold text-slate-600 mb-2 uppercase tracking-wide">Tanda Tangan</p>
            <img src="{{ asset($dokter->tanda_tangan) }}" alt="Tanda Tangan Dokter"
                class="h-16 max-w-[200px] object-contain bg-white border border-slate-200 rounded-[8px] p-2">
        </div>
        @endif

        {{-- Dokumen SIP --}}
        <div class="mt-6 p-5 bg-slate-50 border border-slate-200 rounded-[16px]">
            <p class="text-[13px] font-bold text-slate-600 mb-2 uppercase tracking-wide">Dokumen SIP</p>
            @if($dokter->dokumen_sip)
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-[14px] text-slate-700">{{ basename($dokter->dokumen_sip) }}</span>
                    <a href="{{ asset($dokter->dokumen_sip) }}" target="_blank"
                        class="ml-auto px-4 py-2 bg-slate-500 text-white font-medium rounded-[10px] text-[13px] hover:bg-slate-600 transition-colors shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Buka Dokumen
                    </a>
                </div>
            @else
                <p class="text-[14px] text-slate-400 italic">Belum ada dokumen SIP yang diunggah.</p>
            @endif
        </div>
    </div>

    {{-- Riwayat Jadwal Terbaru (sorted by updated_at / created_at desc) --}}
    @php
        $jadwalTerbaru = $dokter->jadwals
            ->sortByDesc(fn($j) => $j->updated_at ?? $j->created_at)
            ->take(10);
    @endphp
    @if($jadwalTerbaru->isNotEmpty())
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
                    @foreach($jadwalTerbaru as $jadwal)
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

    {{-- Jadwal Operasional Dokter --}}
    <div class="bg-gray-200/50 rounded-[24px] p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[16px] font-bold text-slate-800">Jadwal Operasional Dokter</h3>
            {{-- Tombol Tambah: muncul jika ada hari yang belum dibuat --}}
            @php
                $hariSemua = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                $hariSudahAda = $dokter->jadwalDokters->pluck('hari')->toArray();
                $hariBelumAda = array_diff($hariSemua, $hariSudahAda);
            @endphp
            @if(count($hariBelumAda) > 0)
            <form action="{{ route('admin.dokter.jadwal.generate', $dokter->id) }}" method="POST"
                  onsubmit="return confirm('Tambah semua hari yang belum ada ({{ implode(', ', $hariBelumAda) }}) dengan nilai default dari jadwal sistem?')">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white font-medium rounded-[12px] text-[13px] hover:bg-emerald-600 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Jadwal ({{ count($hariBelumAda) }} hari)
                </button>
            </form>
            @endif
        </div>

        @if($dokter->jadwalDokters->isEmpty())
            <div class="bg-white rounded-[18px] border border-slate-100 px-6 py-10 text-center">
                <p class="text-[14px] text-slate-400 italic">Belum ada jadwal operasional yang terdaftar.</p>
            </div>
        @else
        @php
            $urutanHari = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 7];
            $sortedJadwal = $dokter->jadwalDokters->sortBy(fn($j) => $urutanHari[$j->hari] ?? 99);
        @endphp
        <div class="overflow-x-auto bg-white rounded-[18px] shadow-sm border border-slate-100 px-2 py-2">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[13px] text-slate-600 font-medium border-b border-gray-100">
                        <th class="px-5 py-4">Hari</th>
                        <th class="px-5 py-4">Jam Mulai</th>
                        <th class="px-5 py-4">Jam Selesai</th>
                        <th class="px-5 py-4">Istirahat Mulai</th>
                        <th class="px-5 py-4">Istirahat Selesai</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[13px] text-slate-800 divide-y divide-gray-100">
                    @foreach($sortedJadwal as $jd)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 font-semibold">{{ $jd->hari }}</td>
                        <td class="px-5 py-4">{{ sprintf('%02d:00', $jd->jam_mulai) }}</td>
                        <td class="px-5 py-4">{{ sprintf('%02d:00', $jd->jam_selesai) }}</td>
                        <td class="px-5 py-4">
                            {{ $jd->override_istirahat_mulai !== null ? sprintf('%02d:00', $jd->override_istirahat_mulai) : '—' }}
                        </td>
                        <td class="px-5 py-4">
                            {{ $jd->override_istirahat_selesai !== null ? sprintf('%02d:00', $jd->override_istirahat_selesai) : '—' }}
                        </td>
                        <td class="px-5 py-4">
                            @if($jd->is_aktif)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[12px] font-semibold bg-emerald-50 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[12px] font-semibold bg-slate-100 text-slate-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400 inline-block"></span>
                                    Tidak Tersedia
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.dokter.jadwal.edit', $jd->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium rounded-[8px] text-[12px] transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
