@extends('admin.layouts.app')
@section('title', 'Tambah Data Rekam Medis')
@section('content')
<x-admin.form action="{{ route('admin.rekam-medis.store') }}" method="POST" title="Tambah Data Rekam Medis" subtitle="Masukkan informasi rekam medis pasien." backUrl="{{ route('admin.rekam-medis.index') }}">

    @if($errors->any())
    <div class="mb-2 p-4 bg-rose-50 border border-rose-200 rounded-[12px] text-[13px] text-rose-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jadwal Pasien <span class="text-rose-500">*</span></label>
            <select name="id_jadwal"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('id_jadwal') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="">Pilih Jadwal Pasien</option>
                @foreach($jadwals as $jadwal)
                <option value="{{ $jadwal->id_jadwal }}" {{ old('id_jadwal') == $jadwal->id_jadwal ? 'selected' : '' }}>
                    {{ $jadwal->pasien?->user?->nama ?? '(Tanpa Pasien)' }}
                    — {{ $jadwal->tanggal->format('d M Y') }}
                    ({{ $jadwal->dokter->dr_name }})
                </option>
                @endforeach
            </select>
            @if($jadwals->isEmpty())
            <p class="text-[12px] text-slate-400 mt-1">Tidak ada jadwal selesai yang belum memiliki rekam medis.</p>
            @endif
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Keluhan</label>
            <textarea name="keluhan" rows="3"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Masukkan keluhan pasien">{{ old('keluhan') }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Diagnosa</label>
            <textarea name="diagnosa" rows="3"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Masukkan diagnosa dokter">{{ old('diagnosa') }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Catatan Tambahan</label>
            <textarea name="catatan" rows="3"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Masukkan catatan tambahan jika ada">{{ old('catatan') }}</textarea>
        </div>
    </div>
</x-admin.form>
@endsection
