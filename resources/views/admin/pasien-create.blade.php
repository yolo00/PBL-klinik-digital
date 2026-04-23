@extends('admin.layouts.app')
@section('title', 'Tambah Data Pasien')
@section('content')
<x-admin.form action="{{ route('admin.pasien.store') }}" method="POST" title="Tambah Data Pasien" subtitle="Masukkan informasi pasien baru di bawah ini." backUrl="{{ route('admin.pasien.index') }}">

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="mb-2 p-4 bg-rose-50 border border-rose-200 rounded-[12px] text-[13px] text-rose-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('nama') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Masukkan nama lengkap">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Email <span class="text-rose-500">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('email') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Masukkan email aktif">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Password <span class="text-rose-500">*</span></label>
            <input type="password" name="password"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('password') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Minimal 6 karakter">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">NIM / NIK <span class="text-rose-500">*</span></label>
            <input type="text" name="nimnik" value="{{ old('nimnik') }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('nimnik') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Masukkan NIM atau NIK">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nomor HP <span class="text-rose-500">*</span></label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('no_hp') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Contoh: 0812xxxx">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jenis Kelamin <span class="text-rose-500">*</span></label>
            <select name="jenis_kelamin"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('jenis_kelamin') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Tanggal Lahir <span class="text-rose-500">*</span></label>
            <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('tgl_lahir') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
    </div>
</x-admin.form>
@endsection
