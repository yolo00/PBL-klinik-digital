@extends('pasien.layouts.app')
@section('title', 'Dashboard Pasien')
@section('content')

    <section class="mb-10">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Halo, {{ auth()->user()->nama }} 👋</h1>
        <p class="text-gray-500 mb-6">Selamat datang kembali di sistem layanan Klinik Digital UniHealth.</p>

        <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-8 rounded-2xl flex justify-between items-center shadow-lg shadow-blue-100 border border-blue-400/20">
            <div>
                <p class="font-bold text-white text-xl mb-1">Butuh bantuan dokter?</p>
                <p class="text-blue-50 text-sm opacity-90">Daftar jadwal konsultasi Anda di sini dengan mudah.</p>
            </div>
            <a href="{{ route('pasien.buat-janji') }}" class="bg-white text-blue-600 px-8 py-3 rounded-xl font-bold hover:bg-blue-50 transition shadow-md active:scale-95">
                 Buat Janji Temu
            </a>
        </div>
    </section>

    <div class="grid grid-cols-12 gap-6">
        {{-- Ringkasan Statistik --}}
        <div class="col-span-7 bg-white p-7 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Ringkasan Statistik</h2>
                    <p class="text-sm text-gray-400">Catatan kunjungan terakhir Anda</p>
                </div>
                <span class="bg-blue-50 text-blue-500 p-3 rounded-xl text-xl">
                    <i class="fa-solid fa-chart-line"></i>
                </span>
            </div>
            
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50/30 p-4 rounded-2xl border border-blue-50">
                    <span class="text-[11px] text-blue-400 block mb-1 uppercase font-bold tracking-wider">Terakhir</span>
                    <span class="font-bold text-gray-700 text-sm">{{ $terakhirKunjungan ? $terakhirKunjungan->tanggal->format('d M Y') : '-' }}</span>
                </div>
                <div class="bg-blue-50/30 p-4 rounded-2xl border border-blue-50 text-center">
                    <span class="text-[11px] text-blue-400 block mb-1 uppercase font-bold tracking-wider">Total</span>
                    <span class="font-bold text-3xl text-blue-600">{{ $totalKunjungan }}</span>
                </div>
                <div class="bg-blue-50/30 p-4 rounded-2xl border border-blue-50 text-center">
                    <span class="text-[11px] text-blue-400 block mb-1 uppercase font-bold tracking-wider">Status</span>
                    <span class="font-bold text-lg text-gray-700">{{ auth()->user()->status_akun ?? 'Aktif' }}</span>
                </div>
            </div>
            <a href="{{ route('pasien.rekam-medis') }}" class="mt-6 text-blue-600 font-bold text-sm hover:underline flex items-center gap-2">
                Lihat Rekam Medis Lengkap <span>&rarr;</span>
            </a>
        </div>

{{-- Janji Berikutnya --}}
        <div class="col-span-5 bg-white p-7 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-1">Janji Berikutnya</h2>
            <p class="text-sm text-gray-400 mb-6">Jangan lewatkan jadwal Anda</p>
            
            @if($nextAppointment)
            <div class="bg-slate-50 p-5 rounded-2xl border-l-4 border-blue-500 flex items-center justify-between">
                <div>
                    {{-- 1. PERBAIKAN: Mengambil nama asli dokter dari relasi user --}}
                    <p class="font-bold text-gray-800 text-lg">
                        {{ $nextAppointment->dokter->user->nama ?? ($nextAppointment->dokter->user->name ?? 'Dokter Spesialis') }}
                    </p>
                    
                    {{-- 2. PERBAIKAN: Mengantisipasi teks JSON pada spesialisasi/nama agar tidak muncul mentah --}}
                    <p class="text-xs text-blue-500 font-bold uppercase">
                        @if(json_decode($nextAppointment->dokter->nama))
                            {{-- Jika data JSON "DOKTER UMUM" tersimpan di kolom nama --}}
                            {{ json_decode($nextAppointment->dokter->nama)->NAMA ?? 'Dokter Umum' }}
                        @elseif(is_object($nextAppointment->dokter->spesialisasi))
                            {{ $nextAppointment->dokter->spesialisasi->NAMA ?? 'Dokter Umum' }}
                        @else
                            {{ $nextAppointment->dokter->spesialisasi ?? 'Dokter Umum' }}
                        @endif
                    </p>

                    <div class="mt-3 flex items-center gap-2 text-blue-600 font-bold text-xs uppercase tracking-tighter">
                        <span><i class="fa-solid fa-calendar-days mr-1"></i> {{ $nextAppointment->tanggal->format('d M Y') }}</span>
                        <span><i class="fa-solid fa-clock mr-1"></i>{{ date('H.i', strtotime(str_contains($nextAppointment->jam, ':') ? $nextAppointment->jam : $nextAppointment->jam . ':00')) }} WIB</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-xl border border-blue-50">🩺</div>
            </div>
            @else
                <p class="text-gray-400 text-sm italic">Tidak ada janji temu mendatang.</p>
            @endif
        </div>

{{-- Menunggu Pembayaran --}}
<div class="col-span-7 bg-white p-7 rounded-2xl shadow-sm border border-gray-100 h-fit self-start">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Menunggu Pembayaran</h2>
    
    @if($pendingPayment)
    <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-blue-50">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <p class="font-bold text-gray-800">
                    Konsultasi - {{ $pendingPayment->jadwal->dokter->user->nama ?? $pendingPayment->jadwal->dokter->nama ?? 'Dokter' }}
                </p>
                {{-- Ubah d M Y menjadi d F Y di sini --}}
                <p class="text-xs text-gray-400 mt-1">
                    Jadwal: {{ \Carbon\Carbon::parse($pendingPayment->jadwal->tanggal)->locale('id')->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
        <div class="text-right">
            <p class="font-bold text-blue-600 text-xl mb-2">Rp {{ number_format($pendingPayment->jumlah, 0, ',', '.') }}</p>
            <a href="{{ route('pasien.pembayaran.qris', $pendingPayment->id) }}" class="bg-emerald-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-emerald-600 transition shadow-md shadow-emerald-100 active:scale-95 inline-block">Bayar</a>
        </div>
    </div>
    @else
        <p class="text-gray-400 text-sm">Tidak ada tagihan tertunda.</p>
    @endif
</div>

        {{-- Informasi Klinik --}}
        <div class="col-span-5 bg-[#3b98e8] p-7 rounded-2xl shadow-xl text-white relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white opacity-20 rounded-full blur-xl"></div>
            
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 relative z-10">
                <span class="bg-white/20 p-2 rounded-lg">📍</span> Informasi Klinik
            </h2>

            <div class="space-y-4 relative z-10">
                @foreach ($jadwalKlinik as $jadwal)
                    <div class="border-b border-white/20 pb-3">
                        <div class="flex justify-between items-center text-base">
                            <span class="text-blue-50 font-medium">
                                {{ $jadwal['hari'] }}
                            </span>

                            @if ($jadwal['data']->is_libur)
                                <span class="font-bold text-red-200">
                                    Tutup
                                </span>
                            @else
                                <span class="font-bold text-white">
                                    {{ $jadwal['data']->jam_buka_format }}
                                    -
                                    {{ $jadwal['data']->jam_tutup_format }}
                                </span>
                            @endif
                        </div>

                        @if (!$jadwal['data']->is_libur)
                            <div class="text-sm text-blue-100 mt-1">
                                Istirahat:
                                {{ $jadwal['data']->jam_istirahat_display }}
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="mt-6">
                    <p class="text-[11px] font-bold text-blue-100 mb-1 uppercase tracking-widest">Emergency Call:</p>
                    <p class="text-xl font-black tracking-wider text-white">+62-671-2345-6789</p>
                </div>
            </div>
        </div>
    </div>
@endsection