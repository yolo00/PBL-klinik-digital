@extends('admin.layouts.app')
@section('title', 'Edit Jadwal Dokter')
@section('content')

@php
    $jamBuka    = $jadwalSistem && $jadwalSistem->jam_buka  !== null ? $jadwalSistem->jam_buka  : 0;
    $jamTutup   = $jadwalSistem && $jadwalSistem->jam_tutup !== null ? $jadwalSistem->jam_tutup : 23;
    $isLibur    = $jadwalSistem ? (bool) $jadwalSistem->is_libur : false;
@endphp

<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Edit Jadwal Dokter</h2>
                <p class="text-[14px] text-slate-500 mt-1">
                    {{ $jadwalDokter->dokter->user->nama ?? '—' }}
                    &mdash; <span class="font-semibold text-indigo-600">{{ $jadwalDokter->hari }}</span>
                </p>
            </div>
            <a href="{{ route('admin.dokter.show', $jadwalDokter->id_dokter) }}"
               class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">
                Kembali
            </a>
        </div>

        {{-- Info Jam Operasional Klinik --}}
        <div class="mb-6 p-4 rounded-[14px]
            {{ $isLibur ? 'bg-red-50 border border-red-200' : 'bg-indigo-50 border border-indigo-200' }}">
            <p class="text-[13px] font-bold uppercase tracking-wide
                {{ $isLibur ? 'text-red-600' : 'text-indigo-700' }} mb-1">
                Jam Operasional Klinik — {{ $jadwalDokter->hari }}
            </p>
            @if($isLibur)
                <p class="text-[13px] text-red-600">Klinik libur pada hari ini. Jadwal dokter akan dinonaktifkan.</p>
            @elseif($jadwalSistem)
                <p class="text-[13px] text-indigo-700">
                    {{ sprintf('%02d:00', $jamBuka) }} – {{ sprintf('%02d:00', $jamTutup) }}
                    @if($jadwalSistem->jam_istirahat_mulai !== null)
                        &nbsp;|&nbsp; Istirahat: {{ sprintf('%02d:00', $jadwalSistem->jam_istirahat_mulai) }}
                        @if($jadwalSistem->jam_istirahat_selesai !== null)
                            – {{ sprintf('%02d:00', $jadwalSistem->jam_istirahat_selesai) }}
                        @endif
                    @endif
                </p>
                <p class="text-[12px] text-indigo-500 mt-0.5">Jam dokter harus berada dalam rentang ini.</p>
            @else
                <p class="text-[13px] text-slate-500 italic">Jadwal sistem untuk hari ini belum dikonfigurasi.</p>
            @endif
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-[12px]">
            <ul class="text-[13px] text-red-600 space-y-1 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.dokter.jadwal.update', $jadwalDokter->id) }}" class="space-y-5">
            @method('PUT')
            @csrf

            {{-- Hari (readonly) --}}
            <div>
                <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Hari</label>
                <input type="text" value="{{ $jadwalDokter->hari }}" disabled
                    class="w-full px-4 py-2.5 rounded-[12px] border border-slate-200 bg-slate-100 text-slate-500 text-[14px] cursor-not-allowed">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Jam Mulai --}}
                <div>
                    <label for="jam_mulai" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Jam Mulai <span class="text-red-500">*</span>
                    </label>
                    <select id="jam_mulai" name="jam_mulai"
                        class="w-full px-4 py-2.5 rounded-[12px] border border-slate-200 bg-white text-[14px] text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-shadow
                        {{ $isLibur ? 'opacity-60 cursor-not-allowed' : '' }}"
                        {{ $isLibur ? 'disabled' : '' }}>
                        @for($h = $jamBuka; $h <= $jamTutup; $h++)
                            <option value="{{ $h }}" {{ (int) old('jam_mulai', $jadwalDokter->jam_mulai) === $h ? 'selected' : '' }}>
                                {{ sprintf('%02d:00', $h) }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Jam Selesai --}}
                <div>
                    <label for="jam_selesai" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Jam Selesai <span class="text-red-500">*</span>
                    </label>
                    <select id="jam_selesai" name="jam_selesai"
                        class="w-full px-4 py-2.5 rounded-[12px] border border-slate-200 bg-white text-[14px] text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-shadow
                        {{ $isLibur ? 'opacity-60 cursor-not-allowed' : '' }}"
                        {{ $isLibur ? 'disabled' : '' }}>
                        @for($h = $jamBuka; $h <= $jamTutup; $h++)
                            <option value="{{ $h }}" {{ (int) old('jam_selesai', $jadwalDokter->jam_selesai) === $h ? 'selected' : '' }}>
                                {{ sprintf('%02d:00', $h) }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Jam Istirahat Mulai --}}
                <div>
                    <label for="override_istirahat_mulai" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Jam Istirahat Mulai
                        <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <select id="override_istirahat_mulai" name="override_istirahat_mulai"
                        class="w-full px-4 py-2.5 rounded-[12px] border border-slate-200 bg-white text-[14px] text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-shadow
                        {{ $isLibur ? 'opacity-60 cursor-not-allowed' : '' }}"
                        {{ $isLibur ? 'disabled' : '' }}>
                        <option value="">— Tidak ada —</option>
                        @for($h = $jamBuka; $h <= $jamTutup; $h++)
                            <option value="{{ $h }}" {{ old('override_istirahat_mulai', $jadwalDokter->override_istirahat_mulai) == $h ? 'selected' : '' }}>
                                {{ sprintf('%02d:00', $h) }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Jam Istirahat Selesai --}}
                <div>
                    <label for="override_istirahat_selesai" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Jam Istirahat Selesai
                        <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <select id="override_istirahat_selesai" name="override_istirahat_selesai"
                        class="w-full px-4 py-2.5 rounded-[12px] border border-slate-200 bg-white text-[14px] text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-shadow
                        {{ $isLibur ? 'opacity-60 cursor-not-allowed' : '' }}"
                        {{ $isLibur ? 'disabled' : '' }}>
                        <option value="">— Tidak ada —</option>
                        @for($h = $jamBuka; $h <= $jamTutup; $h++)
                            <option value="{{ $h }}" {{ old('override_istirahat_selesai', $jadwalDokter->override_istirahat_selesai) == $h ? 'selected' : '' }}>
                                {{ sprintf('%02d:00', $h) }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Status Aktif --}}
            <div class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200 rounded-[14px]">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_aktif" value="0">
                    <input type="checkbox" id="is_aktif" name="is_aktif" value="1"
                        class="sr-only peer"
                        {{ old('is_aktif', $jadwalDokter->is_aktif) ? 'checked' : '' }}
                        {{ $isLibur ? 'disabled' : '' }}>
                    <div class="w-11 h-6 bg-slate-300 rounded-full peer peer-checked:bg-indigo-500 transition-colors
                                after:content-[''] after:absolute after:top-0.5 after:left-0.5
                                after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                                peer-checked:after:translate-x-full"></div>
                </label>
                <div>
                    <p class="text-[14px] font-semibold text-slate-700">Status Aktif</p>
                    <p class="text-[12px] text-slate-400">Nonaktifkan jika dokter tidak tersedia di hari ini.</p>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.dokter.show', $jadwalDokter->id_dokter) }}"
                   class="px-6 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-[12px] text-[14px] hover:bg-indigo-700 transition-colors shadow-sm
                    {{ $isLibur ? 'opacity-60 cursor-not-allowed' : '' }}"
                    {{ $isLibur ? 'disabled' : '' }}>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
