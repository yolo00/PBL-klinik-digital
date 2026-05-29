@extends('admin.layouts.app')
@section('title', 'Edit Data Jadwal')
@section('content')

<x-admin.form
    action="{{ route('admin.jadwal.update', $jadwal->id) }}"
    method="POST"
    title="Edit Data Jadwal"
    subtitle="Perbarui informasi jadwal konsultasi #{{ $jadwal->id }}."
    backUrl="{{ route('admin.jadwal.show', $jadwal->id) }}">

    @method('PUT')

    {{-- Error summary --}}
    @if($errors->any())
    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 rounded-[12px] text-[13px] text-rose-700">
        <p class="font-semibold mb-1">Terdapat kesalahan pada input:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Dokter --}}
        <div class="space-y-2">
            <label for="id_dokter" class="text-[14px] font-medium text-slate-700">
                Dokter <span class="text-rose-500">*</span>
            </label>
            <select id="id_dokter" name="id_dokter"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('id_dokter') ? 'border-rose-400 bg-rose-50' : 'border-slate-200 bg-white' }}
                       focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none">
                <option value="">— Pilih Dokter —</option>
                @foreach($dokters as $dokter)
                <option value="{{ $dokter->id }}"
                    {{ old('id_dokter', $jadwal->id_dokter) == $dokter->id ? 'selected' : '' }}>
                    {{ $dokter->user->nama ?? '(Tanpa Nama)' }}
                    @if($dokter->spesialisasi) — {{ $dokter->spesialisasi->nama }} @endif
                    (ID #{{ $dokter->id }})
                </option>
                @endforeach
            </select>
            @error('id_dokter')
                <p class="text-[12px] text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Pasien --}}
        <div class="space-y-2">
            <label for="id_pasien" class="text-[14px] font-medium text-slate-700">
                Pasien
                <span class="text-slate-400 text-[12px] font-normal">(opsional)</span>
            </label>
            <select id="id_pasien" name="id_pasien"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-white
                       focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none">
                <option value="">— Tanpa Pasien —</option>
                @foreach($pasiens as $pasien)
                <option value="{{ $pasien->id }}"
                    {{ old('id_pasien', $jadwal->id_pasien) == $pasien->id ? 'selected' : '' }}>
                    {{ $pasien->user->nama ?? '(Tanpa Nama)' }}
                    (ID #{{ $pasien->id }})
                </option>
                @endforeach
            </select>
            @error('id_pasien')
                <p class="text-[12px] text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal --}}
        <div class="space-y-2">
            <label for="tanggal" class="text-[14px] font-medium text-slate-700">
                Tanggal <span class="text-rose-500">*</span>
            </label>
            <input type="date" id="tanggal" name="tanggal"
                value="{{ old('tanggal', $jadwal->tanggal->toDateString()) }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('tanggal') ? 'border-rose-400 bg-rose-50' : 'border-slate-200' }}
                       focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
            @error('tanggal')
                <p class="text-[12px] text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jam --}}
        <div class="space-y-2">
            <label for="jam" class="text-[14px] font-medium text-slate-700">
                Jam <span class="text-rose-500">*</span>
            </label>
            <select id="jam" name="jam"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('jam') ? 'border-rose-400 bg-rose-50' : 'border-slate-200 bg-white' }}
                       focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none">
                <option value="">— Pilih Jam —</option>
                @for($h = 7; $h <= 20; $h++)
                <option value="{{ $h }}"
                    {{ old('jam', $jadwal->jam) == $h ? 'selected' : '' }}>
                    {{ sprintf('%02d:00', $h) }}
                </option>
                @endfor
            </select>
            @error('jam')
                <p class="text-[12px] text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status --}}
        <div class="space-y-2 md:col-span-2">
            <label for="status" class="text-[14px] font-medium text-slate-700">
                Status <span class="text-rose-500">*</span>
            </label>
            <select id="status" name="status"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('status') ? 'border-rose-400 bg-rose-50' : 'border-slate-200 bg-white' }}
                       focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none">
                <option value="menunggu"     {{ old('status', $jadwal->status) === 'menunggu'     ? 'selected' : '' }}>Menunggu</option>
                <option value="dikonfirmasi" {{ old('status', $jadwal->status) === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="selesai"      {{ old('status', $jadwal->status) === 'selesai'      ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan"   {{ old('status', $jadwal->status) === 'dibatalkan'   ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @error('status')
                <p class="text-[12px] text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

    </div>
</x-admin.form>

@endsection