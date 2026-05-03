@extends('pasien.layouts.app')

@section('title', 'Profil Pasien')

@section('content')
<div class="mb-10">
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('pasien.dashboard') }}" class="w-10 h-10 bg-white rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:text-emerald-500 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-[32px] font-black text-slate-800 leading-tight">Profil Pasien</h1>
    </div>
    <p class="text-slate-400 font-medium ml-14">Kelola informasi pribadi dan pengaturan akun Anda.</p>
</div>

<div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-12">
    
    <div class="flex flex-col md:flex-row items-center gap-8 mb-12 pb-12 border-b border-slate-50">
        <div class="relative group">
            <div class="w-32 h-32 bg-slate-100 rounded-[35px] flex items-center justify-center overflow-hidden border-4 border-white shadow-md">
                <i class="fa-solid fa-user text-5xl text-slate-300"></i>
            </div>
            <button class="absolute -bottom-2 -right-2 bg-slate-800 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xs shadow-lg hover:bg-emerald-600 transition-all">
                <i class="fa-solid fa-camera"></i>
            </button>
        </div>
        
        <div class="text-center md:text-left">
            <h2 class="text-2xl font-black text-slate-800 mb-1">Aprillia Bunga</h2>
            <p class="text-emerald-500 font-black uppercase tracking-[2px] text-[11px] mb-4">Pasien</p>
            <button class="px-6 py-2.5 bg-slate-100 text-slate-500 rounded-xl text-[10px] font-black uppercase hover:bg-slate-200 transition-all">Ubah Foto</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Email</label>
            <input type="email" value="bubungchii27@gmail.com" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">NIK / NIM</label>
            <input type="text" value="3312501032" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Lahir</label>
            <input type="text" value="15 Juni 2007" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Kelamin</label>
            <input type="text" value="Perempuan" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2 md:col-span-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor Kontak / WhatsApp</label>
            <input type="text" value="089671168857" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>
    </div>

    <div class="mt-12 flex flex-col md:flex-row gap-4 justify-end border-t border-slate-50 pt-8">
        <button class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl text-[11px] font-black uppercase hover:bg-red-50 hover:text-red-500 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-power-off"></i> Logout
        </button>
        <button class="px-10 py-4 bg-slate-800 text-white rounded-2xl text-[11px] font-black uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
            <i class="fa-solid fa-user-pen"></i> Edit Profil
        </button>
    </div>
</div>
@endsection
