@extends('pasien.layouts.app')

@section('title', 'Riwayat Jadwal')

@section('content')
<header class="flex justify-between items-center mb-10 bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">Riwayat Jadwal Anda</h2>
        
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
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Riwayat Jadwal</h1>
            <p class="text-gray-500 text-sm">Melihat daftar janji Anda sebelumnya dan yang akan datang.</p>
        </div>
        <div class="flex gap-3">
            <input type="text" placeholder="Cari dokter..." class="text-sm border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <select class="text-sm border border-gray-200 rounded-lg px-4 py-2 focus:outline-none">
                <option>Terbaru</option>
                <option>Terlama</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-400 text-[10px] uppercase tracking-wider border-b border-gray-50">
                    <th class="px-4 py-4 font-bold">Tanggal & Waktu</th>
                    <th class="px-4 py-4 font-bold">Dokter</th>
                    <th class="px-4 py-4 font-bold">Status Jadwal</th>
                    <th class="px-4 py-4 font-bold">Pembayaran</th>
                    <th class="px-4 py-4 font-bold">Rekam Medis</th>
                    <th class="px-4 py-4 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-4 py-5">
                        <span class="block font-bold">12 April 2026</span>
                        <span class="text-xs text-gray-400">09:00 WIB</span>
                    </td>
                    <td class="px-4 py-5">
                        <span class="block font-medium">Dr. Fenni</span>
                        <span class="text-[10px] text-gray-400 uppercase">Dokter Umum</span>
                    </td>
                    <td class="px-4 py-5">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 uppercase">Mendatang</span>
                    </td>
                    <td class="px-4 py-5">
                        <a href="{{ route('pasien.pembayaran') }}" class="px-4 py-2 bg-emerald-500 text-white text-[10px] font-bold rounded-full uppercase hover:bg-emerald-600 transition inline-block">
                            Bayar
                        </a>
                    </td>
                    <td class="px-4 py-5">
                        <button disabled class="px-4 py-2 bg-gray-100 text-gray-400 text-[10px] font-bold rounded-full uppercase cursor-not-allowed">Belum Tersedia</button>
                    </td>
                    <td class="px-4 py-5 text-center">
                        <button class="px-4 py-2 bg-red-50 text-red-500 text-[10px] font-bold rounded-full uppercase hover:bg-red-500 hover:text-white transition">Batalkan</button>
                    </td>
                </tr>

                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-4 py-5 font-bold">10 April 2026 <span class="block text-xs text-gray-400 font-medium">14:00 WIB</span></td>
                    <td class="px-4 py-5 font-medium text-gray-600">Dr. Andi</td>
                    <td class="px-4 py-5">
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-full uppercase">Selesai</span>
                    </td>
                    <td class="px-4 py-5">
                        <a href="{{ route('pasien.riwayat-pembayaran') }}" class="px-4 py-2 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase hover:bg-blue-600 hover:text-white transition inline-block">Lihat Struk</a>
                    </td>
                    <td class="px-4 py-5">
                        <a href="{{ route('pasien.rekam-medis.detail', 2) }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-full uppercase hover:bg-indigo-600 hover:text-white transition inline-block">Lihat Rekam Medis</a>
                    </td>
                    <td class="px-4 py-5 text-center"><span class="text-gray-300">—</span></td>
                </tr>

                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-4 py-5 text-gray-400">08 April 2026 <span class="block text-xs uppercase font-medium">10:00 WIB</span></td>
                    <td class="px-4 py-5 text-gray-400 font-medium">Dr. Siti</td>
                    <td class="px-4 py-5">
                        <span class="px-3 py-1 bg-red-50 text-red-400 text-[10px] font-bold rounded-full uppercase">Dibatalkan</span>
                    </td>
                    <td class="px-4 py-5 text-xs text-gray-400 italic">Refunded</td>
                    <td class="px-4 py-5 text-center text-gray-300">—</td>
                    <td class="px-4 py-5 text-center">
                        <button class="px-4 py-2 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-full uppercase hover:bg-emerald-500 hover:text-white transition">Pesan Lagi</button>
                    </td>
                </tr>

                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-4 py-5 font-bold">15 April 2026 <span class="block text-xs text-gray-400 font-medium">13:00 WIB</span></td>
                    <td class="px-4 py-5 font-medium text-gray-600">Dr. Budi</td>
                    <td class="px-4 py-5">
                        <span class="px-3 py-1 bg-orange-50 text-orange-600 text-[10px] font-bold rounded-full uppercase">Menunggu</span>
                    </td>
                    <td class="px-4 py-5">
                        <span class="px-4 py-2 bg-gray-50 text-gray-400 text-[10px] font-bold rounded-full uppercase">Lunas</span>
                    </td>
                    <td class="px-4 py-5">
                        <button disabled class="px-4 py-2 bg-gray-100 text-gray-400 text-[10px] font-bold rounded-full uppercase cursor-not-allowed">Belum Tersedia</button>
                    </td>
                    <td class="px-4 py-5 text-center">
                        <button class="px-4 py-2 bg-red-50 text-red-500 text-[10px] font-bold rounded-full uppercase hover:bg-red-500 hover:text-white transition">Batalkan</button>
                    </td>
                </tr>

                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-4 py-5 font-bold">05 April 2026 <span class="block text-xs text-gray-400 font-medium">16:00 WIB</span></td>
                    <td class="px-4 py-5 font-medium text-gray-600">Dr. Fenni</td>
                    <td class="px-4 py-5">
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-full uppercase">Selesai</span>
                    </td>
                    <td class="px-4 py-5">
                        <a href="{{ route('pasien.riwayat-pembayaran') }}" class="px-4 py-2 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase hover:bg-blue-600 hover:text-white transition inline-block">Lihat Struk</a>
                    </td>
                    <td class="px-4 py-5">
                        <a href="{{ route('pasien.rekam-medis.detail', 5) }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-full uppercase hover:bg-indigo-600 hover:text-white transition inline-block">Lihat Rekam Medis</a>
                    </td>
                    <td class="px-4 py-5 text-center"><span class="text-gray-300">—</span></td>
                </tr>

                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-4 py-5 font-bold">20 April 2026 <span class="block text-xs text-gray-400 font-medium">08:00 WIB</span></td>
                    <td class="px-4 py-5 font-medium text-gray-600">Dr. Siti</td>
                    <td class="px-4 py-5">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase">Mendatang</span>
                    </td>
                    <td class="px-4 py-5">
                        <a href="{{ route('pasien.pembayaran') }}" class="px-4 py-2 bg-emerald-500 text-white text-[10px] font-bold rounded-full uppercase hover:bg-emerald-600 transition inline-block">
                            Bayar
                        </a>
                    </td>
                    <td class="px-4 py-5 text-center text-gray-300">—</td>
                    <td class="px-4 py-5 text-center">
                        <button class="px-4 py-2 bg-red-50 text-red-500 text-[10px] font-bold rounded-full uppercase hover:bg-red-500 hover:text-white transition">Batalkan</button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-5 text-gray-400 font-bold">01 Maret 2026 <span class="block text-xs font-medium">11:00 WIB</span></td>
                    <td class="px-4 py-5 text-gray-400 font-medium">Dr. Andi</td>
                    <td class="px-4 py-5">
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-full uppercase">Selesai</span>
                    </td>
                    <td class="px-4 py-5">
                        <a href="{{ route('pasien.riwayat-pembayaran') }}" class="px-4 py-2 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase hover:bg-blue-600 hover:text-white transition inline-block">Lihat Struk</a>
                    </td>
                    <td class="px-4 py-5">
                        <a href="{{ route('pasien.rekam-medis.detail', 2) }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-full uppercase hover:bg-indigo-600 hover:text-white transition inline-block">Lihat Rekam Medis</a>
                    </td>
                    <td class="px-4 py-5 text-center"><span class="text-gray-300">—</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex justify-center items-center gap-4 text-xs font-bold text-gray-500">
        <button class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition">&lt;</button>
        <span>Halaman 1 dari 2</span>
        <button class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition">&gt;</button>
    </div>
</div>
@endsection