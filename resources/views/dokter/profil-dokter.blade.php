@extends('dokter.layouts.dokter')
@section('title', 'Profil Dokter')

@section('content')
<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-12">

    {{-- Header Profil --}}
    <div class="flex flex-col md:flex-row items-center gap-8 mb-12 pb-12 border-b border-slate-50">
        <div class="w-32 h-32 bg-slate-100 rounded-[35px] flex items-center justify-center overflow-hidden border-4 border-white shadow-md shrink-0">
            @if($user->foto_profil)
                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
            @else
                <i class="fa-solid fa-user-doctor text-5xl text-slate-300"></i>
            @endif
        </div>

        <div class="text-center md:text-left">
            {{-- BUG FIX: nama diambil dari $user, bukan $dokter --}}
            <h2 class="text-2xl font-black text-slate-800 mb-1">{{ $user->nama ?? 'Nama Dokter' }}</h2>
            <p class="text-emerald-500 font-black uppercase tracking-[2px] text-[11px] mb-2">{{ $spesialisDisplay }}</p>
            <p class="text-slate-400 text-sm font-medium">{{ $user->email ?? '-' }}</p>
        </div>
    </div>

    {{-- Detail Data --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Email</label>
            {{-- BUG FIX: email ada di akun_user ($user), bukan di tabel dokter --}}
            <input type="email" value="{{ $user->email ?? '-' }}" readonly
                   class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Spesialisasi</label>
            <input type="text" value="{{ $spesialisDisplay }}" readonly
                   class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            {{-- BUG FIX: tgl_lahir ada di akun_user ($user), bukan $dokter --}}
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Lahir</label>
            <input type="text"
                   value="{{ $user->tgl_lahir ? \Carbon\Carbon::parse($user->tgl_lahir)->format('d F Y') : '-' }}"
                   readonly
                   class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            {{-- BUG FIX: jenis_kelamin ada di akun_user ($user), bukan $dokter --}}
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Kelamin</label>
            <input type="text"
                   value="{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}"
                   readonly
                   class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2 md:col-span-2">
            {{-- BUG FIX: no_hp ada di akun_user ($user), bukan $dokter --}}
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor Telepon</label>
            <input type="text" value="{{ $user->no_hp ?? '-' }}" readonly
                   class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2 md:col-span-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Pendidikan</label>
            <input type="text" value="{{ $dokter->pendidikan ?? '-' }}" readonly
                   class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>
    </div>
</div>
@endsection