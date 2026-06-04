@extends('admin.layouts.app')
@section('title', 'Edit Data Pasien')
@section('content')
<x-admin.form action="{{ route('admin.pasien.update', $pasien->id) }}" method="PUT" title="Edit Data Pasien" subtitle="Perbarui informasi data pasien." backUrl="{{ route('admin.pasien.show', $pasien->id) }}">

    @if($errors->any())
    <div class="mb-2 p-4 bg-rose-50 border border-rose-200 rounded-[12px] text-[13px] text-rose-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $pasien->user->nama ?? '') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('nama') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Email <span class="text-rose-500">*</span></label>
            <input type="email" name="email" value="{{ old('email', $pasien->user->email ?? '') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('email') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Password <span class="text-slate-400 text-[12px]">(Kosongkan jika tidak ingin diubah)</span></label>
            <input type="password" name="password" placeholder="Minimal 6 karakter"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('password') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nomor HP <span class="text-rose-500">*</span></label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $pasien->user->no_hp ?? '') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('no_hp') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jenis Kelamin <span class="text-rose-500">*</span></label>
            <select name="jenis_kelamin" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('jenis_kelamin') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="L" {{ old('jenis_kelamin', $pasien->user->jenis_kelamin ?? '') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $pasien->user->jenis_kelamin ?? '') === 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Tanggal Lahir <span class="text-rose-500">*</span></label>
            <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', $pasien->user->tgl_lahir ?? '') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('tgl_lahir') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Golongan Darah <span class="text-slate-400 text-[12px]">(opsional)</span></label>
            <select name="gol_darah"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="">Pilih Golongan Darah</option>
                <option value="A" {{ old('gol_darah', $pasien->gol_darah) === 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('gol_darah', $pasien->gol_darah) === 'B' ? 'selected' : '' }}>B</option>
                <option value="AB" {{ old('gol_darah', $pasien->gol_darah) === 'AB' ? 'selected' : '' }}>AB</option>
                <option value="O" {{ old('gol_darah', $pasien->gol_darah) === 'O' ? 'selected' : '' }}>O</option>
            </select>
        </div>
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">Riwayat Penyakit <span class="text-slate-400 text-[12px]">(opsional)</span></label>
            <textarea name="riwayat_penyakit" rows="3" placeholder="Masukkan riwayat penyakit jika ada..."
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">{{ old('riwayat_penyakit', $pasien->riwayat_penyakit) }}</textarea>
        </div>
    </div>
</x-admin.form>
@endsection
