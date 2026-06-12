@extends('pasien.layouts.app')
@section('title', 'Profil Pasien')
@section('content')

@if (session('success'))
    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Berhasil! </strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>

    <script>
        setTimeout(function(){
            document.getElementById('success-alert').style.display = 'none';
        }, 3000);
    </script>
@endif
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
            <h2 class="text-2xl font-black text-slate-800 mb-1">{{ $user->nama }}</h2>
            <p class="text-emerald-500 font-black uppercase tracking-[2px] text-[11px] mb-4">Pasien</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Data User --}}
        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Email</label>
            <input type="email" value="{{ $user->email }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Lahir</label>
            <input type="text" value="{{ $user->tgl_lahir ? \Carbon\Carbon::parse($user->tgl_lahir)->format('d F Y') : '-' }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Kelamin</label>
            <input type="text" value="{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor Kontak</label>
            <input type="text" value="{{ $user->no_hp ?? '-' }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        {{-- Data Pasien (Medical Record) --}}
        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Golongan Darah</label>
            <input type="text" value="{{ $pasien->gol_darah ?? '-' }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Riwayat Penyakit</label>
            <input type="text" value="{{ $pasien->riwayat_penyakit ?? '-' }}" readonly class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>

        <div class="space-y-2 md:col-span-2">
            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Alergi</label>
            <input type="text" 
                   value="{{ $pasien && $pasien->alergi->count() > 0 ? $pasien->alergi->pluck('nama_alergi')->implode(', ') : 'Tidak ada alergi' }}" 
                   readonly 
                   class="w-full px-6 py-4 bg-slate-50 rounded-2xl border-none text-slate-800 font-bold outline-none cursor-default">
        </div>
    </div>

    <div class="mt-12 flex flex-col md:flex-row gap-4 justify-end border-t border-slate-50 pt-8">
        <form id="logout-form-pasien" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        <button onclick="event.preventDefault(); document.getElementById('logout-form-pasien').submit();" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl text-[11px] font-black uppercase hover:bg-red-50 hover:text-red-500 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-power-off"></i> Logout
        </button>
        
        <a href="{{ route('pasien.profil.edit') }}" class="px-10 py-4 bg-slate-800 text-white rounded-2xl text-[11px] font-black uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
            <i class="fa-solid fa-user-pen"></i> Edit Profil
        </a>
    </div>
</div>
@endsection