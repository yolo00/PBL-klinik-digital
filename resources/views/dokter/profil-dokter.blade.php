@extends('dokter.layouts.dokter')
@section('title', 'Profil Dokter')

@section('content')
@php
    \Carbon\Carbon::setLocale('id');
@endphp
<div class="max-w-3xl mx-auto">
    {{-- Header halaman --}}
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Profil Dokter</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola informasi identitas dan spesialisasi Anda.</p>
    </div>

    {{-- Header Card Profil --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 p-6 md:p-8 mb-5">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            {{-- Avatar --}}
            <div class="w-24 h-24 rounded-2xl bg-blue-50 border-2 border-blue-100 flex items-center justify-center shrink-0 overflow-hidden">
                @if($user->foto_profil)
                    <img src="{{ asset($user->foto_profil) }}" alt="Foto" class="w-full h-full object-cover">
                @else
                    <i class="fa-solid fa-user-doctor text-4xl text-blue-300"></i>
                @endif
            </div>

            {{-- Info --}}
            <div class="text-center md:text-left">
                <h2 class="text-2xl font-bold text-slate-800">{{ $user->nama ?? 'Nama Dokter' }}</h2>
                <p class="text-blue-600 font-bold uppercase tracking-widest text-[11px] mt-1">{{ $spesialisDisplay }}</p>
                <p class="text-slate-400 text-sm mt-1">{{ $user->email ?? '-' }}</p>

                <div class="mt-3 flex flex-wrap justify-center md:justify-start gap-2">
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-xl text-xs font-semibold border border-blue-100 inline-flex items-center gap-1">
                        <i class="fa-solid fa-stethoscope"></i> Dokter Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Data --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 p-6 md:p-8">
        <p class="text-[11px] font-bold text-blue-500 uppercase tracking-widest mb-6">Data Diri</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Alamat Email</label>
                <div class="px-4 py-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 font-medium text-sm break-words">
                    {{ $user->email ?? '-' }}
                </div>
            </div>

            <div>
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Spesialisasi</label>
                <div class="px-4 py-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 font-medium text-sm break-words">
                    {{ $spesialisDisplay }}
                </div>
            </div>

            <div>
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Tanggal Lahir</label>
                <div class="px-4 py-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 font-medium text-sm">
                    {{ $user->tgl_lahir
                        ? \Carbon\Carbon::parse($user->tgl_lahir)->translatedFormat('d F Y')
                        : '-' }}
                </div>
            </div>

            <div>
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Jenis Kelamin</label>
                <div class="px-4 py-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 font-medium text-sm">
                    {{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Nomor Telepon</label>
                <div class="px-4 py-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 font-medium text-sm">
                    {{ $user->no_hp ?? '-' }}
                </div>
            </div>

            @if($dokter && $dokter->pendidikan)
                <div class="md:col-span-2">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Pendidikan</label>
                    <div class="px-4 py-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 font-medium text-sm break-words">
                        {{ $dokter->pendidikan }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
