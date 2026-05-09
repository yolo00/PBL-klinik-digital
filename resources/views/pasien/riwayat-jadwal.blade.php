@extends('pasien.layouts.app')
@section('title', 'Riwayat Jadwal')
@section('content')

<div class="animate-fade-in px-4 py-6 md:px-8">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Jadwal</h1>
        <p class="text-lg text-slate-500 mt-2">Melihat daftar janji Anda sebelumnya dan yang akan datang.</p>
    </div>

    {{-- Container disesuaikan menjadi rounded-3xl --}}
    <div class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden">
        
        {{-- Penambahan Search Bar dan Filter agar Konsisten --}}
        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" placeholder="Cari dokter atau tanggal..." class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-base focus:ring-2 focus:ring-emerald-500 transition shadow-sm">
            </div>
            <select class="w-full md:w-48 bg-slate-50 border-none rounded-2xl text-base text-slate-600 focus:ring-2 focus:ring-emerald-500 py-3.5 px-4 shadow-sm cursor-pointer">
                <option>Semua Status</option>
                <option>Mendatang</option>
                <option>Selesai</option>
                <option>Dibatalkan</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                {{-- Header <th> disesuaikan: bg-slate-50/50, tracking-widest, text-slate-400 --}}
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Tanggal & Waktu</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Dokter</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Status Jadwal</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Pembayaran</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Rekam Medis</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    {{-- Row 1: Mendatang --}}
                    <tr class="hover:bg-slate-50/80 transition-all duration-200">
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-800">12 April 2026</div>
                            <div class="text-sm text-slate-400 font-medium mt-0.5">09:00 WIB</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-700">Dr. Fenni</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 uppercase border border-blue-100 shadow-sm">
                                Mendatang
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <a href="{{ route('pasien.pembayaran') }}"
                                class="inline-flex px-6 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-bold shadow-sm shadow-emerald-200 hover:bg-emerald-600 transition transform active:scale-95">
                                Bayar
                            </a>
                        </td>
                        <td class="px-8 py-6">
                            <button disabled
                                class="inline-flex px-4 py-2.5 rounded-xl bg-gray-100 text-gray-400 text-xs font-bold uppercase cursor-not-allowed">
                                Belum Tersedia
                            </button>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <button class="inline-flex px-4 py-2.5 rounded-xl bg-red-50 text-red-500 text-xs font-bold uppercase hover:bg-red-500 hover:text-white transition shadow-sm">
                                Batalkan
                            </button>
                        </td>
                    </tr>

                    {{-- Row 2: Selesai --}}
                    <tr class="hover:bg-slate-50/80 transition-all duration-200">
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-800">10 April 2026</div>
                            <div class="text-sm text-slate-400 font-medium mt-0.5">9:00 WIB</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-700">Dr. Fenni</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-gray-600 uppercase border border-slate-200 shadow-sm">
                                Selesai
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <a href="{{ route('pasien.riwayat-pembayaran') }}"
                                class="inline-flex px-4 py-2.5 rounded-xl bg-blue-50 text-blue-600 text-xs font-bold uppercase border border-blue-100 hover:bg-blue-600 hover:text-white transition shadow-sm">
                                Lihat Struk
                            </a>
                        </td>
                        <td class="px-8 py-6">
                            <a href="{{ route('pasien.rekam-medis.detail', 2) }}"
                                class="inline-flex px-4 py-2.5 rounded-xl bg-indigo-50 text-indigo-600 text-xs font-bold uppercase border border-indigo-100 hover:bg-indigo-600 hover:text-white transition shadow-sm">
                                Rekam Medis
                            </a>
                        </td>
                        <td class="px-8 py-6 text-center text-slate-300">—</td>
                    </tr>

                    {{-- Row 3: Dibatalkan --}}
                    <tr class="hover:bg-slate-50/80 transition-all duration-200">
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-400">08 April 2026</div>
                            <div class="text-sm text-slate-300 font-medium mt-0.5">10:00 WIB</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-400">Dr. Siti</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-400 uppercase border border-red-100 shadow-sm">
                                Dibatalkan
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs italic text-gray-400 font-medium">Refunded</span>
                        </td>
                        <td class="px-8 py-6 text-center text-slate-300">—</td>
                        <td class="px-8 py-6 text-center">
                            <a href="{{ route('pasien.buat-janji') }}" 
                               class="inline-flex px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 text-xs font-bold uppercase border border-emerald-100 hover:bg-emerald-500 hover:text-white transition decoration-none shadow-sm">
                                Pesan Lagi
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-sm font-medium text-slate-500">Menampilkan <span class="text-slate-900 font-bold">1 - 3</span> dari <span class="text-slate-900 font-bold"> 3 </span> Jadwal </span>
            <div class="flex gap-3">
                <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed transition hover:bg-slate-50 shadow-sm">Sebelumnya</button>
                <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed transition hover:bg-slate-50 shadow-sm">Selanjutnya</button>
            </div>
        </div>
    </div>
</div>
@endsection