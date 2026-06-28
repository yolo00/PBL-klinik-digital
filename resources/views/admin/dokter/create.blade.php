@extends('admin.layouts.app')
@section('title', 'Tambah Data Dokter')
@section('content')
<x-admin.form action="{{ route('admin.dokter.store') }}" method="POST" title="Tambah Data Dokter" subtitle="Masukkan informasi dokter baru di bawah ini." backUrl="{{ route('admin.dokter.index') }}" enctype="multipart/form-data">

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
            <input type="text" name="nama" value="{{ old('nama') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('nama') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700"
                placeholder="Contoh: Fenni Patrik Simanjuntak">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Email <span class="text-rose-500">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('email') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700"
                placeholder="Masukkan email aktif">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Password <span class="text-rose-500">*</span></label>
            <input type="password" name="password" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('password') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700"
                placeholder="Minimal 6 karakter">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Spesialisasi <span class="text-rose-500">*</span></label>
            <select name="id_spesialisasi" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('id_spesialisasi') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="">Pilih Spesialisasi</option>
                @foreach($spesialisasis as $sp)
                    <option value="{{ $sp->id }}" {{ old('id_spesialisasi') == $sp->id ? 'selected' : '' }}>
                        {{ $sp->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nomor HP <span class="text-rose-500">*</span></label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('no_hp') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700"
                placeholder="Contoh: 0812xxxx">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jenis Kelamin <span class="text-rose-500">*</span></label>
            <select name="jenis_kelamin" required
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('jenis_kelamin') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Tanggal Lahir <span class="text-rose-500">*</span></label>
            <input type="text" id="tgl_lahir_picker" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required
                placeholder="Pilih tanggal lahir" readonly
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('tgl_lahir') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700 cursor-pointer bg-white">
        </div>

        {{-- Pendidikan --}}
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Pendidikan <span class="text-slate-400 text-[12px]">(opsional)</span></label>
            <input type="text" name="pendidikan" value="{{ old('pendidikan') }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('pendidikan') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700"
                placeholder="Contoh: S1 Kedokteran Umum, Sp.PD">
        </div>

        {{-- Foto Profil --}}
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Foto Profil <span class="text-slate-400 text-[12px]">(opsional — JPG, PNG maks. 2MB)</span></label>
            <input type="file" name="foto_profil" accept=".jpg,.jpeg,.png"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('foto_profil') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[13px] file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
        </div>

        {{-- Tanda Tangan --}}
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Tanda Tangan <span class="text-slate-400 text-[12px]">(opsional — PNG maks. 2MB)</span></label>
            <input type="file" name="tanda_tangan" accept=".png"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('tanda_tangan') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[13px] file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
        </div>

        {{-- Dokumen SIP --}}
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">Dokumen SIP <span class="text-slate-400 text-[12px]">(opsional — PDF, JPG, PNG maks. 2MB)</span></label>
            <input type="file" name="dokumen_sip" accept=".pdf,.jpg,.jpeg,.png"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('dokumen_sip') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[13px] file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
        </div>
    </div>
</x-admin.form>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    flatpickr('#tgl_lahir_picker', {
        locale: 'id',
        dateFormat: 'Y-m-d',
        maxDate: 'today',
        defaultDate: document.getElementById('tgl_lahir_picker').value || null,
        allowInput: false,
    });
});
</script>
@endpush
@endsection
