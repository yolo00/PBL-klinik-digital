@extends('dokter.layouts.dokter')

@section('title', 'Profil Dokter')

@section('content')
<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-12">
    <div class="flex flex-col md:flex-row items-center gap-8 mb-12 pb-12 border-b border-slate-50">
        <div class="relative group">
            <div class="w-32 h-32 bg-slate-100 rounded-[35px] flex items-center justify-center overflow-hidden border-4 border-white shadow-md">
                <i class="fa-solid fa-user-doctor text-5xl text-slate-300"></i>
            </div>
        </div>
        
        <div class="text-center md:text-left">
            <h2 class="text-2xl font-black text-slate-800 mb-1">{{ $dokter->user->nama ?? 'Nama Dokter' }}</h2>
            <p class="text-emerald-500 font-black uppercase tracking-[2px] text-[11px] mb-4">{{ $dokter->spesialisasi ?? 'Dokter' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Email</label>
            <input type="email" value="{{ $dokter->user->email }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Spesialis</label>
            <input type="text" value="{{ $spesialisDisplay }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Lahir</label>
            <input type="text" value="{{ $dokter->tgl_lahir ?? '-' }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Kelamin</label>
            <input type="text" value="{{ $dokter->jenis_kelamin ?? '-' }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2 md:col-span-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor Kontak / WhatsApp</label>
            <input type="text" value="{{ $dokter->no_hp ?? '-' }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>
    </div>
    </div>
@endsection