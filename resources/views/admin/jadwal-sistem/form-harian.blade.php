@extends('admin.layouts.app')
@section('title', 'Edit Jam Operasional — ' . $jadwal->hari)
@section('content')

<x-admin.form
    action="{{ route('admin.jadwal-sistem.harian.update', $jadwal) }}"
    method="PUT"
    title="Edit Jam Operasional — {{ $jadwal->hari }}"
    subtitle="Ubah jam buka, tutup, dan istirahat klinik untuk hari ini."
    backUrl="{{ route('admin.jadwal-sistem') }}"
    submitLabel="Perbarui Jam"
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

        {{-- Toggle Libur --}}
        <div class="md:col-span-2">
            <label class="flex items-center gap-3 cursor-pointer select-none group">
                <div class="relative">
                    <input type="hidden" name="is_libur" value="0">
                    <input type="checkbox" id="cbLibur" name="is_libur" value="1"
                           {{ old('is_libur', $jadwal->is_libur) ? 'checked' : '' }}
                           class="sr-only peer"
                           onchange="toggleLibur(this.checked)">
                    <div class="w-11 h-6 rounded-full bg-slate-200 peer-checked:bg-rose-500 transition-colors duration-200"></div>
                    <div class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow
                                transition-transform duration-200 peer-checked:translate-x-5"></div>
                </div>
                <div>
                    <p class="text-[14px] font-semibold text-slate-700">Klinik tutup di hari ini</p>
                    <p class="text-[12px] text-slate-400">Aktifkan jika klinik tidak beroperasi setiap {{ $jadwal->hari }}.</p>
                </div>
            </label>
        </div>

        {{-- Fieldset jam --}}
        <fieldset id="fieldsetJam"
                  class="{{ old('is_libur', $jadwal->is_libur) ? 'opacity-40 pointer-events-none' : '' }}
                         md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 transition-opacity duration-200">

            {{-- Jam Buka --}}
            <div class="space-y-2">
                <label class="text-[14px] font-medium text-slate-700">
                    Jam Buka <span class="text-rose-500">*</span>
                    <span class="text-slate-400 text-[12px] font-normal">(0–23, contoh: 8 = 08:00)</span>
                </label>
                <input type="number" name="jam_buka" min="0" max="23"
                       value="{{ old('jam_buka', $jadwal->jam_buka) }}"
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
                       value="{{ old('jam_tutup', $jadwal->jam_tutup) }}"
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
                       value="{{ old('jam_istirahat_mulai', $jadwal->jam_istirahat_mulai) }}"
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
                       value="{{ old('jam_istirahat_selesai', $jadwal->jam_istirahat_selesai) }}"
                       placeholder="13"
                       class="w-full px-4 py-3 rounded-[12px] border border-slate-200
                              focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all text-slate-700">
            </div>

        </fieldset>

    </div>

</x-admin.form>

@push('scripts')
<script>
function toggleLibur(isLibur) {
    const fs = document.getElementById('fieldsetJam');
    fs.classList.toggle('opacity-40', isLibur);
    fs.classList.toggle('pointer-events-none', isLibur);
}
document.addEventListener('DOMContentLoaded', () => {
    const cb = document.getElementById('cbLibur');
    if (cb) toggleLibur(cb.checked);
});
</script>
@endpush

@endsection