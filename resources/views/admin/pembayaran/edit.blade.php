@extends('admin.layouts.app')
@section('title', 'Edit Pembayaran')
@section('content')

<x-admin.form
    action="{{ route('admin.pembayaran.update', $pembayaran->id) }}"
    method="POST"
    title="Edit Pembayaran"
    subtitle="Perbarui data pembayaran #{{ $pembayaran->id }}."
    backUrl="{{ route('admin.pembayaran.show', $pembayaran->id) }}">

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

    @if($pembayaran->metode === 'qris')
    <div class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded-[12px] text-[13px] text-purple-700 flex items-start gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <p class="font-semibold">Pembayaran Menggunakan QRIS</p>
            <p class="mt-1">Detail jumlah tagihan, status, dan metode dikelola secara otomatis melalui integrasi Xendit. Anda tidak dapat mengubah detail ini secara manual.</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Jadwal (read-only) --}}
        <div class="space-y-2 md:col-span-2">
            <label class="text-[14px] font-medium text-slate-700">Jadwal</label>
            <input type="text"
                value="{{ $pembayaran->jadwal->pasien?->user?->nama ?? '(Tanpa Pasien)' }} — {{ $pembayaran->jadwal->tanggal->format('d M Y') }} · {{ sprintf('%02d:00', $pembayaran->jadwal->jam) }} ({{ $pembayaran->jadwal->dokter?->user?->nama ?? '—' }})"
                disabled
                class="w-full px-4 py-3 rounded-[12px] border border-slate-200 bg-slate-50 text-slate-500 text-[14px] cursor-not-allowed">
            <p class="text-[12px] text-slate-400">Jadwal tidak dapat diubah setelah pembayaran dibuat.</p>
        </div>

        {{-- Jumlah --}}
        <div class="space-y-2">
            <label for="jumlah" class="text-[14px] font-medium text-slate-700">Jumlah (Rp) <span class="text-rose-500">*</span></label>
            <input type="number" id="jumlah" name="jumlah"
                value="{{ old('jumlah', (int) $pembayaran->jumlah) }}"
                {{ $pembayaran->metode === 'qris' ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('jumlah') ? 'border-rose-400 bg-rose-50' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed"
                placeholder="Contoh: 150000" min="0" step="1000">
            @error('jumlah')
                <p class="text-[12px] text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nomor Struk --}}
        <div class="space-y-2">
            <label for="nomor_struk" class="text-[14px] font-medium text-slate-700">Nomor Struk <span class="text-slate-400 text-[12px] font-normal">(opsional)</span></label>
            <input type="text" id="nomor_struk" name="nomor_struk"
                value="{{ old('nomor_struk', $pembayaran->nomor_struk) }}"
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('nomor_struk') ? 'border-rose-400 bg-rose-50' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all font-mono"
                placeholder="Contoh: STR-20260601-001" maxlength="50">
            @error('nomor_struk')
                <p class="text-[12px] text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Metode --}}
        <div class="space-y-2">
            <label for="metode" class="text-[14px] font-medium text-slate-700">Metode Pembayaran <span class="text-rose-500">*</span></label>
            @if($pembayaran->metode === 'qris')
                <input type="hidden" name="metode" value="qris">
            @endif
            <select id="metode" name="metode" {{ $pembayaran->metode === 'qris' ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('metode') ? 'border-rose-400 bg-rose-50' : 'border-slate-200 bg-white' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed">
                <option value="cash"     {{ old('metode', $pembayaran->metode) === 'cash'     ? 'selected' : '' }}>Cash</option>
                <option value="qris"     {{ old('metode', $pembayaran->metode) === 'qris'     ? 'selected' : '' }}>QRIS</option>
                <option value="transfer" {{ old('metode', $pembayaran->metode) === 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
            </select>
            @error('metode')
                <p class="text-[12px] text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status --}}
        <div class="space-y-2">
            <label for="status" class="text-[14px] font-medium text-slate-700">Status <span class="text-rose-500">*</span></label>
            @if($pembayaran->metode === 'qris')
                <input type="hidden" name="status" value="{{ $pembayaran->status }}">
            @endif
            <select id="status" name="status" {{ $pembayaran->metode === 'qris' ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-[12px] border {{ $errors->has('status') ? 'border-rose-400 bg-rose-50' : 'border-slate-200 bg-white' }} focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 text-[14px] transition-all appearance-none disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed">
                <option value="pending" {{ old('status', $pembayaran->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="lunas"   {{ old('status', $pembayaran->status) === 'lunas'   ? 'selected' : '' }}>Lunas</option>
                <option value="batal"   {{ old('status', $pembayaran->status) === 'batal'   ? 'selected' : '' }}>Batal</option>
            </select>
            @error('status')
                <p class="text-[12px] text-rose-600">{{ $message }}</p>
            @enderror
        </div>

    </div>
</x-admin.form>

@endsection
