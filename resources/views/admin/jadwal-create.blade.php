@extends('admin.layouts.app')
@section('title', 'Tambah Data Jadwal')
@section('content')
<x-admin.form action="{{ route('admin.jadwal.store') }}" method="POST" title="Tambah Data Jadwal" subtitle="Masukkan informasi jadwal konsultasi baru." backUrl="{{ route('admin.jadwal.index') }}">

    @if($errors->any())
    <div class="mb-2 p-4 bg-rose-50 border border-rose-200 rounded-[12px] text-[13px] text-rose-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Dokter <span class="text-rose-500">*</span></label>
            <select name="id_dokter"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('id_dokter') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="">Pilih Dokter</option>
                @foreach($dokters as $dokter)
                <option value="{{ $dokter->id_dokter }}" {{ old('id_dokter') == $dokter->id_dokter ? 'selected' : '' }}>
                    {{ $dokter->dr_name }} — {{ $dokter->spesialis }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Pasien <span class="text-slate-400 text-[12px]">(opsional)</span></label>
            <select name="id_pasien"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="">Tanpa Pasien</option>
                @foreach($pasiens as $pasien)
                <option value="{{ $pasien->id_pasien }}" {{ old('id_pasien') == $pasien->id_pasien ? 'selected' : '' }}>
                    {{ $pasien->user->nama ?? '—' }} ({{ $pasien->nimnik }})
                </option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Tanggal <span class="text-rose-500">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('tanggal') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jam <span class="text-rose-500">*</span></label>
            <input type="time" name="jam" value="{{ old('jam') }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('jam') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
        </div>
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">Status <span class="text-rose-500">*</span></label>
            <select name="status"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="menunggu"     {{ old('status','menunggu') === 'menunggu'     ? 'selected' : '' }}>Menunggu</option>
                <option value="dikonfirmasi" {{ old('status') === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="selesai"      {{ old('status') === 'selesai'      ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan"   {{ old('status') === 'dibatalkan'   ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
    </div>
</x-admin.form>
@endsection
