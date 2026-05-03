@extends('pasien.layouts.app')
@section('title', 'Dashboard Pasien')
@section('content')

    <section class="mb-10">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Halo, Aprillia Bunga 👋</h1>
        <p class="text-gray-500 mb-6">Selamat datang kembali di sistem layanan Klinik Digital UniHealth.</p>

        <div class="bg-white p-6 rounded-2xl flex justify-between items-center shadow-sm border border-blue-50">
            <div>
                <p class="font-semibold text-gray-800 text-lg">Butuh bantuan dokter?</p>
                <p class="text-sm text-gray-500">Daftar jadwal konsultasi Anda di sini dengan mudah.</p>
            </div>
            <a href="{{ route('pasien.buat-janji') }}" class="bg-blue-500 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-600 transition shadow-lg shadow-blue-100">
                Daftar Jadwal
            </a>
        </div>
    </section>

    <div class="grid grid-cols-12 gap-6">
        </div>

    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-7 bg-white p-7 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Ringkasan Statistik</h2>
                    <p class="text-sm text-gray-400">Catatan kunjungan terakhir Anda</p>
                </div>
                <span class="bg-green-100 text-klinik-green p-2 rounded-lg text-xl">📊</span>
            </div>
            
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-klinik-bg p-4 rounded-2xl border border-gray-50">
                    <span class="text-[11px] text-gray-400 block mb-1 uppercase font-bold tracking-wider">Terakhir</span>
                    <span class="font-bold text-gray-700">10 April 2026</span>
                </div>
                <div class="bg-klinik-bg p-4 rounded-2xl border border-gray-50 text-center">
                    <span class="text-[11px] text-gray-400 block mb-1 uppercase font-bold tracking-wider">Total</span>
                    <span class="font-bold text-3xl text-klinik-green">4</span>
                </div>
                <div class="bg-klinik-bg p-4 rounded-2xl border border-gray-50 text-center">
                    <span class="text-[11px] text-gray-400 block mb-1 uppercase font-bold tracking-wider">Status</span>
                    <span class="font-bold text-lg text-gray-700">Aktif</span>
                </div>
            </div>
            <a href="#" class="mt-6 text-klinik-blue font-bold text-sm hover:underline flex items-center gap-2">
                Lihat Rekam Medis Lengkap <span>&rarr;</span>
            </a>
        </div>

        <div class="col-span-5 bg-white p-7 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-1">Janji Berikutnya</h2>
            <p class="text-sm text-gray-400 mb-6">Jangan lewatkan jadwal Anda</p>
            
            <div class="bg-klinik-bg p-5 rounded-2xl border-l-4 border-klinik-blue flex items-center justify-between">
                <div>
                    <p class="font-bold text-gray-800 text-lg">Dr. Fenni</p>
                    <p class="text-xs text-gray-500 font-medium">Dokter Umum</p>
                    <div class="mt-3 flex items-center gap-2 text-klinik-blue font-bold text-xs uppercase tracking-tighter">
                        <span>📅 12 Apr 2026</span>
                        <span>⏰ 9.00 WIB</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-xl">🩺</div>
            </div>
        </div>

        <div class="col-span-7 bg-white p-7 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Menunggu Pembayaran</h2>
            <div class="flex items-center justify-between p-5 bg-klinik-bg rounded-2xl border border-blue-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-klinik-blue rounded-xl flex items-center justify-center font-bold">INV</div>
                    <div>
                        <p class="font-bold text-gray-800">Konsultasi - Dr. Fenni</p>
                        <p class="text-xs text-gray-400">Jadwal: 12 April 2026</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-900 text-lg mb-2">Rp 50.000</p>
                    <button class="bg-emerald-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-green-600 transition shadow-md shadow-green-100">Bayar</button>
                </div>
            </div>
        </div>

        <div class="col-span-5 bg-klinik-blue p-7 rounded-2xl shadow-xl text-white relative overflow-hidden">
    <div class="absolute -right-4 -top-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
    
    <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-black">
    <span>📍</span> Informasi Klinik
</h2>

<div class="space-y-4 relative z-10 text-black">

    <div class="flex justify-between items-center text-base border-b border-gray-300 pb-3">
        <span class="font-medium">Senin - Jumat</span>
        <span class="font-bold">08:00 - 17:00</span>
    </div>
    
    <div class="flex justify-between items-center text-base border-b border-gray-300 pb-3">
        <span class="font-medium">Sabtu</span>
        <span class="font-bold">10:00 - 14:00</span>
    </div>

    <div class="mt-6">
        <p class="text-sm font-semibold text-gray-700 mb-1">
            Emergency Call:
        </p>

        <p class="text-xl font-black tracking-wider text-black">
            +62-671-2345-6789
        </p>
    </div>
</div>

    </div>
@endsection