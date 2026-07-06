@extends('dokter.layouts.dokter')
@section('title', 'Konfirmasi Rekam Medis')

@section('content')
<div class="max-w-4xl mx-auto">
@php
    \Carbon\Carbon::setLocale('id');
@endphp

    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Konfirmasi Rekam Medis</h1>
            <p class="text-slate-400 text-sm mt-1">
                Jadwal #{{ $jadwal->id }} — {{ $jadwal->tanggal
                                                ? \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y')
                                                : '-' }}
                , {{ $jadwal->jam_format ?? sprintf('%02d', $jadwal->jam).':00' }} WIB
            </p>
        </div>
        <a href="{{ route('dokter.jadwal.buat-rekam', $jadwal->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition-all">
            <i class="fa-solid fa-arrow-left"></i> Kembali Edit
        </a>
    </div>

    <div class="mb-6 p-4 rounded-2xl border border-rose-200 bg-rose-50">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
            </div>
            <div>
                <p class="font-bold text-rose-700">Rekam medis tidak dapat diedit setelah dikonfirmasi</p>
                <p class="text-sm text-rose-600 mt-1">
                    Pastikan seluruh data sudah sesuai sebelum menekan tombol <span class="font-semibold">Konfirmasi & Simpan</span>.
                </p>
            </div>
        </div>
    </div>

    {{-- Preview --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50">
            <h2 class="text-sm font-bold text-slate-700">Preview Data</h2>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2 bg-slate-50 border border-slate-100 rounded-2xl p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Pasien</p>
                <p class="font-bold text-slate-800 mt-1">{{ $jadwal->pasien->user->nama ?? '-' }}</p>
            </div>

            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Keluhan</p>
                <p class="text-slate-700 leading-relaxed mt-2">{{ $keluhan ?? '-' }}</p>
            </div>

            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Diagnosa</p>
                <p class="text-slate-700 leading-relaxed mt-2">{{ $diagnosa ?? '-' }}</p>
            </div>

            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 md:col-span-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Catatan Tambahan (Opsional)</p>
                <p class="text-slate-700 leading-relaxed mt-2">{{ $catatan ?? '-' }}</p>
            </div>

            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 md:col-span-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Resep Obat (Opsional)</p>
                @if(!empty($resep) && count($resep))
                    <ul class="mt-2 space-y-2">
                        @foreach($resep as $r)
                            @if(!empty($r['obat']))
                                <li class="text-sm text-slate-700">
                                    <span class="font-semibold">{{ $r['obat'] }}</span>
                                    <span class="text-slate-500"> — {{ $r['dosis'] ?? '-' }}, {{ $r['aturan_pakai'] ?? '-' }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-slate-500 mt-2">Tidak ada resep obat.</p>
                @endif
            </div>
        </div>

        <div class="px-6 py-4 border-t border-slate-50 flex justify-end gap-3">
            <form action="{{ route('dokter.rekam-medis.konfirmasi', $jadwal->id) }}" method="POST">
                @csrf
                {{-- membawa data preview --}}
                <input type="hidden" name="keluhan" value="{{ $keluhan }}">
                <input type="hidden" name="diagnosa" value="{{ $diagnosa }}">
                <input type="hidden" name="catatan" value="{{ $catatan }}">

                @if(!empty($resep) && is_array($resep))
                    @foreach($resep as $idx => $item)
                        @if(!empty($item['obat']))
                            <input type="hidden" name="resep[{{ $idx }}][obat]" value="{{ $item['obat'] }}">
                            <input type="hidden" name="resep[{{ $idx }}][dosis]" value="{{ $item['dosis'] ?? '' }}">
                            <input type="hidden" name="resep[{{ $idx }}][aturan_pakai]" value="{{ $item['aturan_pakai'] ?? '' }}">
                        @endif
                    @endforeach
                @endif

                <button type="submit"
                        class="px-8 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 shadow-sm transition-all flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    Konfirmasi & Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

