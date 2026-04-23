@extends('admin.layouts.app')
@section('title', 'Tambah Data Pembayaran')
@section('content')
<x-admin.form action="{{ route('admin.pembayaran.store') }}" method="POST" title="Tambah Data Pembayaran" subtitle="Masukkan informasi pembayaran pasien." backUrl="{{ route('admin.pembayaran.index') }}">

    @if($errors->any())
    <div class="mb-2 p-4 bg-rose-50 border border-rose-200 rounded-[12px] text-[13px] text-rose-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">Jadwal / Pasien <span class="text-rose-500">*</span></label>
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
            <p class="text-[12px] text-slate-400 mt-1">Semua jadwal sudah memiliki pembayaran.</p>
            @endif
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Jumlah (Rp) <span class="text-rose-500">*</span></label>
            <input type="number" name="jumlah" value="{{ old('jumlah') }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('jumlah') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Contoh: 150000" min="0">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Nomor Struk</label>
            <input type="text" name="nomor_struk" value="{{ old('nomor_struk') }}"
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all"
                placeholder="Masukkan nomor struk (opsional)">
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Metode Pembayaran <span class="text-rose-500">*</span></label>
            <select name="metode"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('metode') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="cash" {{ old('metode','cash') === 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="qris" {{ old('metode') === 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[14px] font-medium text-slate-700">Status <span class="text-rose-500">*</span></label>
            <select name="status"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('status') ? 'border-rose-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none bg-white">
                <option value="pending" {{ old('status','pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="lunas"   {{ old('status') === 'lunas'   ? 'selected' : '' }}>Lunas</option>
                <option value="batal"   {{ old('status') === 'batal'   ? 'selected' : '' }}>Batal</option>
            </select>
        </div>
    </div>
</x-admin.form>
@endsection
