@extends('admin.layouts.app')
@section('title', 'Tambah Spesialisasi')
@section('content')
<div class="space-y-6 max-w-2xl">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.spesialisasi.index') }}" class="text-slate-400 hover:text-slate-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Tambah Spesialisasi</h3>
    </div>

    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.spesialisasi.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="nama" class="block text-sm font-bold text-slate-700 mb-2">Nama Spesialisasi</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Contoh: Dokter Jantung"
                    class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('nama') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all">
                @error('nama')
                    <p class="text-rose-500 text-[12px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="base_price" class="block text-sm font-bold text-slate-700 mb-2">Biaya Dasar</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium text-[14px]">Rp</span>
                    <input type="number" name="base_price" id="base_price" value="{{ old('base_price', 0) }}" required min="0" step="1000"
                        class="w-full pl-11 pr-4 py-3 rounded-[12px] border {{ $errors->has('base_price') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all">
                </div>
                <p class="text-[12px] text-slate-400 mt-2">Tarif ini akan menjadi dasar perhitungan biaya konsultasi.</p>
                @error('base_price')
                    <p class="text-rose-500 text-[12px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-8 py-3 bg-slate-800 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-900 transition-colors shadow-sm">
                    Simpan
                </button>
                <a href="{{ route('admin.spesialisasi.index') }}" class="px-8 py-3 bg-gray-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-gray-200 transition-colors shadow-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
