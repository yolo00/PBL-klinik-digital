@extends('pasien.layouts.app')

@section('title', 'Dashboard Pasien')
@section('content')
<header class="flex justify-between items-center mb-10 bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">Rekaman Medis</h2>
        
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
<div class="animate-fade-in px-4 py-6 md:px-8">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Rekam Medis</h1>
        <p class="text-lg text-slate-500 mt-2">Lihat riwayat kesehatan dan catatan medis Anda dari kunjungan sebelumnya.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" placeholder="Cari dokter atau diagnosa..." class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-base focus:ring-2 focus:ring-emerald-500 transition shadow-sm">
            </div>
            <select class="w-full md:w-48 bg-slate-50 border-none rounded-2xl text-base text-slate-600 focus:ring-2 focus:ring-emerald-500 py-3.5 px-4 shadow-sm cursor-pointer">
                <option>Urutkan: Terbaru</option>
                <option>Tahun 2025</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Tanggal & Waktu</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Dokter Spesialis</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Diagnosa</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50/80 transition-all duration-200">
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-800">12 April 2026</div>
                            <div class="text-sm text-slate-400 font-medium mt-0.5">09:00 WIB</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-700">Dr. Fenni</div>
                            <div class="text-xs text-emerald-600 font-black uppercase tracking-wider mt-0.5">Dokter Umum</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 bg-blue-50 text-blue-600 text-sm font-bold rounded-full border border-blue-100 shadow-sm">
                                Influenza & Demam
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">                
                            <a href="{{ route('pasien.rekam-medis.detail') }}" class="inline-block bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm shadow-emerald-200 transition-all transform active:scale-95">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/80 transition-all duration-200">
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-800">28 Maret 2026</div>
                            <div class="text-sm text-slate-400 font-medium mt-0.5">14:00 WIB</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-700">Dr. Andi</div>
                            <div class="text-xs text-blue-600 font-black uppercase tracking-wider mt-0.5">Spesialis Penyakit Dalam</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 bg-amber-50 text-amber-600 text-sm font-bold rounded-full border border-amber-100 shadow-sm">
                                Gastritis Akut
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <button class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm shadow-emerald-200 transition-all transform active:scale-95">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition opacity-70 bg-slate-50/20">
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-500 text-slate-400">15 Februari 2026</div>
                            <div class="text-sm text-slate-400 font-medium mt-0.5">10:30 WIB</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-500 text-slate-400">Dr. Siti</div>
                            <div class="text-xs text-slate-400 font-black uppercase tracking-wider mt-0.5">Dokter Gigi</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 bg-slate-100 text-slate-500 text-sm font-bold rounded-full border border-slate-200 shadow-sm">
                                Pembersihan Karang Gigi
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <button class="bg-slate-200 text-slate-500 px-6 py-2.5 rounded-xl text-sm font-bold cursor-not-allowed">
                                Terarsipkan
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="p-8 bg-slate-50 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-sm font-medium text-slate-500 italic">Menampilkan <span class="text-slate-900 font-bold">1 - 3</span> dari <span class="text-slate-900 font-bold">3</span> Rekam Medis</span>
            <div class="flex gap-3">
                <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed transition hover:bg-slate-50">Sebelumnya</button>
                <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-emerald-600 transition hover:border-emerald-500 hover:bg-emerald-50 active:scale-95">Selanjutnya</button>
            </div>
        </div>
    </div>
</div>
@endsection