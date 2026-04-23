@extends('admin.layouts.app')
@section('title', 'Edit Data Dokter')
@section('content')
<x-admin.form action="{{ route('admin.dokter.index') }}" method="POST" title="Edit Data Dokter" subtitle="Fitur update akan segera tersedia." backUrl="{{ route('admin.dokter.show', $dokter->id_dokter) }}">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nama Dokter</label>
            <input type="text" value="{{ $dokter->user->nama ?? '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Email</label>
            <input type="email" value="{{ $dokter->user->email ?? '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Spesialis</label>
            <input type="text" value="{{ $dokter->spesialis }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nomor HP</label>
            <input type="text" value="{{ $dokter->user->no_hp ?? '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jenis Kelamin</label>
            <input type="text" value="{{ $dokter->user->jenis_kelamin_label ?? '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Tanggal Lahir</label>
            <input type="text" value="{{ $dokter->user->tgl_lahir ? \Carbon\Carbon::parse($dokter->user->tgl_lahir)->format('d M Y') : '' }}" disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
        </div>
    </div>
</x-admin.form>
@endsection
