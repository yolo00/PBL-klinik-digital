@extends('admin.layouts.app')
@section('title', 'Edit Data Pasien')
@section('content')
<x-admin.form action="{{ route('admin.pasien.index') }}" method="POST" title="Edit Data Pasien" subtitle="Fitur update akan segera tersedia." backUrl="{{ route('admin.pasien.show', $pasien->id_pasien) }}">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nama Lengkap</label>
            <input type="text" value="{{ $pasien->user->nama ?? '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Email</label>
            <input type="email" value="{{ $pasien->user->email ?? '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">NIM / NIK</label>
            <input type="text" value="{{ $pasien->nimnik }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nomor HP</label>
            <input type="text" value="{{ $pasien->user->no_hp ?? '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jenis Kelamin</label>
            <input type="text" value="{{ $pasien->user->jenis_kelamin_label ?? '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Tanggal Lahir</label>
            <input type="text" value="{{ $pasien->user->tgl_lahir ? \Carbon\Carbon::parse($pasien->user->tgl_lahir)->format('d M Y') : '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
    </div>
</x-admin.form>
@endsection
