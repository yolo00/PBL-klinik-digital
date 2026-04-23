@extends('pasien.layouts.app')

@section('title', 'Booking Janji Temu')

@section('content')
    <header class="flex justify-between items-center mb-10 bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">Booking Janji Temu</h2>
        
        <div class="relative" x-data="{ open: false }">
            <div @click="open = !open" class="flex items-center gap-4 cursor-pointer hover:bg-gray-50 p-1 rounded-xl transition">
                <div class="text-right">
                    <p class="font-bold text-gray-800 text-sm">Aprillia Bunga</p>
                    <span class="text-[10px] bg-blue-100 text-klinik-blue px-2 py-0.5 rounded-full font-bold uppercase">Pasien</span>
                </div>
                <div class="w-10 h-10 bg-klinik-blue rounded-full flex items-center justify-center text-white font-bold relative">
                    AB
                    <div class="absolute -right-1 -bottom-1 bg-white rounded-full shadow-sm">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Lihat Profil</a>
                <hr class="my-1 border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition w-full text-left font-medium">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <section class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2 tracking-tight">Booking Janji Temu</h1>
        <p class="text-gray-500 text-lg">Silakan pilih dokter, tanggal, dan waktu kunjungan Anda.</p>
    </section>

    <form action="#" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-10">
        
        <div class="space-y-4">
            <label class="block text-lg font-bold text-gray-800 flex items-center gap-3">
                <span class="text-2xl">👤</span> Pilih Dokter
            </label>
            <div class="relative">
                <select class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-klinik-blue focus:border-klinik-blue outline-none transition-all appearance-none text-gray-700">
                    <option>Dr. Fenni | Dokter Umum</option>
                    <option>Dr. Gizan | Dokter Umum</option>
                    <option>Drg. Ryan | Spesialis Gigi</option>
                    <option>Dr. Siti | Spesialis Anak</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="space-y-4">
                <label class="block text-lg font-bold text-gray-800 flex items-center gap-3">
                    <span class="text-2xl">📅</span> Pilih Tanggal
                </label>
                <input type="date" value="2026-04-08" class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-klinik-blue outline-none text-gray-700 font-medium">
            </div>

            <div class="space-y-4">
                <label class="block text-lg font-bold text-gray-800 flex items-center gap-3">
                    <span class="text-2xl">⏰</span> Pilih Waktu
                </label>
                <div class="relative">
                    <select class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-klinik-blue outline-none transition-all appearance-none text-gray-700 font-medium">
                        <option>08:00 WIB</option>
                        <option disabled class="text-gray-400">09:00 WIB (Penuh)</option>
                        <option>10:00 WIB</option>
                        <option selected>11:00 WIB</option>
                        <option>13:00 WIB</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-10 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center bg-gray-50 p-8 rounded-3xl gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1 font-medium">Biaya Pendaftaran</p>
                <p class="text-3xl font-black text-gray-900">Rp 50.000 <span class="text-sm font-medium text-gray-400">(QRIS Only)</span></p>
            </div>
            <button type="submit" class="w-full md:w-auto bg-klinik-blue text-white px-12 py-5 rounded-2xl font-bold text-lg hover:bg-blue-600 transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-3">
                📅 Daftar Jadwal Sekarang
            </button>
        </div>

    </form>
@endsection