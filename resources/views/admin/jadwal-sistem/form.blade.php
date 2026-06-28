@extends('admin.layouts.app')
@section('title', $mode === 'create' ? 'Tambah Jadwal Khusus' : 'Edit Jadwal Khusus')
@section('content')

<x-admin.form
    action="{{ $mode === 'create' ? route('admin.jadwal-sistem.store') : route('admin.jadwal-sistem.update', $jadwal) }}"
    method="{{ $mode === 'create' ? 'POST' : 'PUT' }}"
    title="{{ $mode === 'create' ? 'Tambah Tanggal Libur / Jadwal Khusus' : 'Edit Jadwal — ' . \Carbon\Carbon::parse($jadwal->tgl_khusus)->locale('id')->isoFormat('D MMMM YYYY') }}"
    subtitle="Tanggal libur nasional, cuti bersama, atau hari dengan jam operasional berbeda dari biasanya."
    backUrl="{{ route('admin.jadwal-sistem') }}"
    submitLabel="{{ $mode === 'create' ? 'Simpan Jadwal' : 'Perbarui Jadwal' }}"
>

    @if($errors->any())
    <div class="p-4 bg-rose-50 border border-rose-200 rounded-[12px] text-[13px] text-rose-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Tanggal --}}
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">
                Tanggal <span class="text-rose-500">*</span>
            </label>
            <input type="text" id="tgl_khusus_picker" name="tgl_khusus"
                   value="{{ old('tgl_khusus', $jadwal?->tgl_khusus?->format('Y-m-d')) }}"
                   placeholder="Pilih tanggal" readonly
                   class="w-full px-4 py-3 rounded-[12px] border
                          {{ $errors->has('tgl_khusus') ? 'border-rose-400 bg-rose-50' : 'border-slate-200' }}
                          focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700 cursor-pointer bg-white">
            @error('tgl_khusus')
            <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Toggle Libur --}}
        <div class="md:col-span-2">
            <label class="flex items-center gap-3 cursor-pointer select-none group">
                <div class="relative">
                    <input type="hidden" name="is_libur" value="0">
                    <input type="checkbox" id="cbLibur" name="is_libur" value="1"
                           {{ old('is_libur', $jadwal?->is_libur) ? 'checked' : '' }}
                           class="sr-only peer"
                           onchange="toggleLibur(this.checked)">
                    {{-- Track --}}
                    <div class="w-11 h-6 rounded-full bg-slate-200 peer-checked:bg-rose-500 transition-colors duration-200"></div>
                    {{-- Thumb --}}
                    <div class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow
                                transition-transform duration-200
                                peer-checked:translate-x-5"></div>
                </div>
                <div>
                    <p class="text-[14px] font-semibold text-slate-700">Tandai sebagai hari libur</p>
                    <p class="text-[12px] text-slate-400">Aktifkan jika klinik tutup penuh pada tanggal ini.</p>
                </div>
            </label>
        </div>

        {{-- ── Jam Operasional (disegel jika libur) ── --}}
        <fieldset id="fieldsetJam"
                  class="{{ old('is_libur', $jadwal?->is_libur) ? 'opacity-40 pointer-events-none' : '' }}
                         md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 transition-opacity duration-200">

            {{-- Jam Buka --}}
            <div class="space-y-2">
                <label class="text-[14px] font-medium text-slate-700">
                    Jam Buka <span class="text-rose-500">*</span>
                    <span class="text-slate-400 text-[12px] font-normal">(contoh: 8 = 08:00)</span>
                </label>
                <input type="number" name="jam_buka" min="0" max="23"
                       value="{{ old('jam_buka', $jadwal?->jam_buka) }}"
                       placeholder="8"
                       class="w-full px-4 py-3 rounded-[12px] border
                              {{ $errors->has('jam_buka') ? 'border-rose-400 bg-rose-50' : 'border-slate-200' }}
                              focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
                @error('jam_buka')
                <p class="text-[12px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jam Tutup --}}
            <div class="space-y-2">
                <label class="text-[14px] font-medium text-slate-700">
                    Jam Tutup <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="jam_tutup" min="0" max="23"
                       value="{{ old('jam_tutup', $jadwal?->jam_tutup) }}"
                       placeholder="17"
                       class="w-full px-4 py-3 rounded-[12px] border
                              {{ $errors->has('jam_tutup') ? 'border-rose-400 bg-rose-50' : 'border-slate-200' }}
                              focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
                @error('jam_tutup')
                <p class="text-[12px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jam Istirahat Mulai --}}
            <div class="space-y-2">
                <label class="text-[14px] font-medium text-slate-700">
                    Jam Istirahat Mulai
                    <span class="text-slate-400 text-[12px] font-normal">(opsional)</span>
                </label>
                <input type="number" name="jam_istirahat_mulai" min="0" max="23"
                       value="{{ old('jam_istirahat_mulai', $jadwal?->jam_istirahat_mulai) }}"
                       placeholder="12"
                       class="w-full px-4 py-3 rounded-[12px] border border-slate-200
                              focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
            </div>

            {{-- Jam Istirahat Selesai --}}
            <div class="space-y-2">
                <label class="text-[14px] font-medium text-slate-700">
                    Jam Istirahat Selesai
                    <span class="text-slate-400 text-[12px] font-normal">(opsional)</span>
                </label>
                <input type="number" name="jam_istirahat_selesai" min="0" max="23"
                       value="{{ old('jam_istirahat_selesai', $jadwal?->jam_istirahat_selesai) }}"
                       placeholder="13"
                       class="w-full px-4 py-3 rounded-[12px] border border-slate-200
                              focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
            </div>

        </fieldset>

        {{-- Keterangan --}}
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">
                Keterangan <span class="text-slate-400 text-[12px] font-normal">(opsional, maks 100 karakter)</span>
            </label>
            <input type="text" name="keterangan" maxlength="100"
                   value="{{ old('keterangan', $jadwal?->keterangan) }}"
                   placeholder="Contoh: Hari Raya Idul Fitri, Cuti Bersama, Operasional Terbatas…"
                   class="w-full px-4 py-3 rounded-[12px] border border-slate-200
                          focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
            @error('keterangan')
            <p class="text-[12px] text-rose-500">{{ $message }}</p>
            @enderror
        </div>

    </div>{{-- end grid --}}

</x-admin.form>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    flatpickr('#tgl_khusus_picker', {
        locale: 'id',
        dateFormat: 'Y-m-d',
        defaultDate: document.getElementById('tgl_khusus_picker').value || null,
        allowInput: false,
    });
});

function toggleLibur(isLibur) {
    const fs = document.getElementById('fieldsetJam');
    fs.classList.toggle('opacity-40', isLibur);
    fs.classList.toggle('pointer-events-none', isLibur);
}
// Inisialisasi saat load
document.addEventListener('DOMContentLoaded', () => {
    const cb = document.getElementById('cbLibur');
    if (cb) toggleLibur(cb.checked);
});
</script>
@endpush

@endsection
