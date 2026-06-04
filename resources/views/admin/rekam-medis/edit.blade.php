@extends('admin.layouts.app')
@section('title', 'Edit Rekam Medis')
@section('content')

<x-admin.form
    action="{{ route('admin.rekam-medis.update', $rekamMedis->id) }}"
    method="POST"
    title="Edit Rekam Medis"
    subtitle="Perbarui rekam medis #{{ $rekamMedis->id }}."
    backUrl="{{ route('admin.rekam-medis.show', $rekamMedis->id) }}">

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

    <div class="grid grid-cols-1 gap-6">

        {{-- Pilih Jadwal --}}
        <div class="space-y-2">
            <label for="id_jadwal" class="text-[14px] font-medium text-slate-700">
                Jadwal Pasien <span class="text-rose-500">*</span>
            </label>
            <select id="id_jadwal" name="id_jadwal"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('id_jadwal') ? 'border-rose-400 bg-rose-50' : 'border-slate-200 bg-white' }}
                       focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none">
                <option value="">— Pilih Jadwal —</option>
                @foreach($jadwals as $jadwal)
                <option value="{{ $jadwal->id }}"
                    {{ old('id_jadwal', $rekamMedis->id_jadwal) == $jadwal->id ? 'selected' : '' }}>
                    {{ $jadwal->pasien?->user?->nama ?? '(Tanpa Pasien)' }}
                    · {{ $jadwal->tanggal->translatedFormat('d M Y') }}
                    · {{ sprintf('%02d:00', $jadwal->jam) }}
                    · {{ $jadwal->dokter?->user?->nama ?? '—' }}
                    (Jadwal #{{ $jadwal->id }})
                </option>
                @endforeach
            </select>
            @error('id_jadwal')
                <p class="text-[12px] text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Keluhan --}}
        <div class="space-y-2">
            <label for="keluhan" class="text-[14px] font-medium text-slate-700">Keluhan</label>
            <textarea id="keluhan" name="keluhan" rows="3"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('keluhan') ? 'border-rose-400 bg-rose-50' : 'border-slate-200' }}
                       focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all resize-none"
                placeholder="Masukkan keluhan pasien…">{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
            @error('keluhan')
                <p class="text-[12px] text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Diagnosa --}}
        <div class="space-y-2">
            <label for="diagnosa" class="text-[14px] font-medium text-slate-700">Diagnosa</label>
            <textarea id="diagnosa" name="diagnosa" rows="3"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('diagnosa') ? 'border-rose-400 bg-rose-50' : 'border-slate-200' }}
                       focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all resize-none"
                placeholder="Masukkan diagnosa dokter…">{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
            @error('diagnosa')
                <p class="text-[12px] text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Catatan --}}
        <div class="space-y-2">
            <label for="catatan" class="text-[14px] font-medium text-slate-700">Catatan Tambahan</label>
            <textarea id="catatan" name="catatan" rows="3"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('catatan') ? 'border-rose-400 bg-rose-50' : 'border-slate-200' }}
                       focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all resize-none"
                placeholder="Masukkan catatan tambahan jika ada…">{{ old('catatan', $rekamMedis->catatan) }}</textarea>
            @error('catatan')
                <p class="text-[12px] text-rose-600">{{ $message }}</p>
            @enderror
        </div>

    </div>
</x-admin.form>

@endsection
