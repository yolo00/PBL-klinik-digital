@extends('admin.layouts.app')
@section('title', 'Detail Jadwal')
@section('content')

<div class="space-y-6">


    {{-- Info utama --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">

        <div class="flex flex-wrap items-start justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Detail Jadwal Konsultasi</h2>
                <p class="text-[14px] text-slate-500 mt-1">ID Jadwal #{{ $jadwal->id }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}"
                    class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors">
                    Edit
                </a>
                {{-- Hapus (hanya untuk jadwal bukan selesai) --}}
                @if($jadwal->status !== 'selesai')
                <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus jadwal ini? Tindakan tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2.5 bg-rose-50 text-rose-600 font-medium rounded-[12px] text-[14px] hover:bg-rose-100 transition-colors border border-rose-200">
                        Hapus
                    </button>
                </form>
                @endif
                <a href="{{ route('admin.jadwal.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-[12px] text-[14px] hover:bg-slate-200 transition-colors">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Pasien --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Pasien</p>
                @if($jadwal->pasien?->user)
                    <p class="text-[15px] font-semibold text-slate-800">{{ $jadwal->pasien->user->nama }}</p>
                    <p class="text-[13px] text-slate-500">ID Pasien #{{ $jadwal->pasien->id }}</p>
                @else
                    <p class="text-[15px] text-slate-400 italic">Tanpa Pasien</p>
                @endif
            </div>

            {{-- Dokter --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Dokter</p>
                <p class="text-[15px] font-semibold text-slate-800">{{ $jadwal->dokter->user->nama ?? '—' }}</p>
                <p class="text-[13px] text-slate-500">
                    {{ $jadwal->dokter->spesialisasi->nama ?? '' }}
                    · ID Dokter #{{ $jadwal->dokter->id }}
                </p>
            </div>

            {{-- Tanggal --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Tanggal</p>
                <p class="text-[15px] font-semibold text-slate-800">
                    {{ $jadwal->tanggal->translatedFormat('l, d F Y') }}
                </p>
            </div>

            {{-- Jam --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Jam</p>
                <p class="text-[15px] font-semibold text-slate-800 font-mono">{{ $jadwal->jam_format }}</p>
            </div>

            {{-- Status --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Status</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[13px] font-semibold {{ $jadwal->status_badge }}">
                    {{ $jadwal->status_label }}
                </span>
            </div>

            {{-- Dibuat --}}
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Dibuat Pada</p>
                <p class="text-[15px] font-semibold text-slate-800">
                    {{ $jadwal->created_at ? \Carbon\Carbon::parse($jadwal->created_at)->format('d M Y, H:i') : '—' }}
                </p>
            </div>

        </div>
    </div>

    {{-- Rekam Medis terkait --}}
    @if($jadwal->rekamMedis)
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
            <h3 class="text-[16px] font-bold text-slate-800">Rekam Medis Terkait</h3>
            <a href="{{ route('admin.rekam-medis.show', $jadwal->rekamMedis->id) }}"
                class="text-[13px] text-slate-500 hover:text-slate-700 font-medium transition-colors">
                Lihat Lengkap →
            </a>
        </div>
        <div class="grid grid-cols-1 gap-5">
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Keluhan</p>
                <p class="text-[14px] text-slate-700">{{ $jadwal->rekamMedis->keluhan ?? '—' }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Diagnosa</p>
                <p class="text-[14px] text-slate-700">{{ $jadwal->rekamMedis->diagnosa ?? '—' }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Catatan</p>
                <p class="text-[14px] text-slate-700">{{ $jadwal->rekamMedis->catatan ?? '—' }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Pembayaran terkait --}}
    @if($jadwal->pembayaran)
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
            <h3 class="text-[16px] font-bold text-slate-800">Pembayaran Terkait</h3>
            <a href="{{ route('admin.pembayaran.show', $jadwal->pembayaran->id) }}"
                class="text-[13px] text-slate-500 hover:text-slate-700 font-medium transition-colors">
                Lihat Lengkap →
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Nomor Struk</p>
                <p class="text-[14px] font-semibold text-slate-800 font-mono">
                    {{ $jadwal->pembayaran->nomor_struk ?? '—' }}
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Jumlah</p>
                <p class="text-[14px] font-semibold text-slate-800">
                    Rp {{ number_format($jadwal->pembayaran->jumlah, 0, ',', '.') }}
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Metode</p>
                <p class="text-[14px] font-semibold text-slate-800 uppercase">
                    {{ $jadwal->pembayaran->metode }}
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-[12px] font-medium text-slate-400 uppercase tracking-wide">Status Bayar</p>
                @php
                    $bayarBadge = match($jadwal->pembayaran->status) {
                        'lunas'   => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                        'batal'   => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                        default   => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                    };
                    $bayarLabel = match($jadwal->pembayaran->status) {
                        'lunas'   => 'Lunas',
                        'batal'   => 'Batal',
                        default   => 'Pending',
                    };
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[13px] font-semibold {{ $bayarBadge }}">
                    {{ $bayarLabel }}
                </span>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection