@extends('admin.layouts.app')
@section('title', 'Edit Data Dokter')
@section('content')
<x-admin.form action="{{ route('admin.dokter.update', $dokter->id) }}" method="PUT" title="Edit Data Dokter" subtitle="Perbarui informasi data dokter." backUrl="{{ route('admin.dokter.show', $dokter->id) }}" enctype="multipart/form-data">

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
            <label class="text-[14px] font-medium text-slate-700">Nama Dokter <span class="text-rose-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $dokter->user->nama ?? '') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('nama') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Email <span class="text-rose-500">*</span></label>
            <input type="email" name="email" value="{{ old('email', $dokter->user->email ?? '') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('email') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Password <span class="text-slate-400 text-[12px]">(Kosongkan jika tidak ingin diubah)</span></label>
            <input type="password" name="password" placeholder="Minimal 6 karakter"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('password') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Spesialisasi <span class="text-rose-500">*</span></label>
            <select name="id_spesialisasi" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('id_spesialisasi') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                @foreach($spesialisasis as $sp)
                    <option value="{{ $sp->id }}" {{ old('id_spesialisasi', $dokter->id_spesialisasi) == $sp->id ? 'selected' : '' }}>
                        {{ $sp->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nomor HP <span class="text-rose-500">*</span></label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $dokter->user->no_hp ?? '') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('no_hp') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jenis Kelamin <span class="text-rose-500">*</span></label>
            <select name="jenis_kelamin" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('jenis_kelamin') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="L" {{ old('jenis_kelamin', $dokter->user->jenis_kelamin ?? '') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $dokter->user->jenis_kelamin ?? '') === 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Tanggal Lahir <span class="text-rose-500">*</span></label>
            <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', $dokter->user->tgl_lahir ?? '') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('tgl_lahir') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>

        {{-- Dokumen SIP --}}
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">Dokumen SIP <span class="text-slate-400 text-[12px]">(opsional — PDF, JPG, PNG maks. 2MB)</span></label>
            @if($dokter->dokumen_sip)
                <div class="mb-3 p-4 bg-slate-50 border border-slate-200 rounded-[12px] flex items-center gap-3">
                    <svg class="w-5 h-5 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-[13px] text-slate-600">File saat ini: <strong>{{ basename($dokter->dokumen_sip) }}</strong></span>
                    <a href="{{ asset($dokter->dokumen_sip) }}" target="_blank"
                        class="ml-auto px-3 py-1.5 bg-slate-500 text-white font-medium rounded-[8px] text-[12px] hover:bg-slate-600 transition-colors shadow-sm">Lihat File</a>
                </div>
            @endif
            <input type="file" name="dokumen_sip" accept=".pdf,.jpg,.jpeg,.png"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('dokumen_sip') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[13px] file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
            @if($dokter->dokumen_sip)
                <p class="text-[12px] text-slate-400 mt-1">Unggah file baru untuk menggantikan dokumen yang sudah ada.</p>
            @endif
        </div>
    </div>
</x-admin.form>
@endsection
