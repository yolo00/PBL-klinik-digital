@extends('pasien.layouts.app')
@section('title', 'Riwayat Jadwal')
@section('content')


<div>
    <h1 class="text-[30px] font-black text-slate-800 leading-tight">Riwayat Jadwal</h1>
    <p class="text-slate-400 font-medium mt-1">Melihat daftar janji Anda sebelumnya dan yang akan datang.</p>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

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
            <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4">
                        <span class="block font-semibold text-gray-800">12 April 2026</span>
                        <span class="text-xs text-gray-400">09:00 WIB</span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="block font-medium text-gray-700">Dr. Fenni</span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-600 uppercase">
                            Mendatang
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <a href="{{ route('pasien.pembayaran') }}"
                            class="inline-flex px-4 py-2 rounded-full bg-emerald-500 text-white text-[11px] font-semibold uppercase hover:bg-emerald-600 transition">
                            Bayar
                        </a>
                    </td>
                    <td class="px-5 py-4">
                        <button disabled
                            class="inline-flex px-4 py-2 rounded-full bg-gray-100 text-gray-400 text-[11px] font-semibold uppercase cursor-not-allowed">
                            Belum Tersedia
                        </button>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <button
                            class="inline-flex px-4 py-2 rounded-full bg-red-50 text-red-500 text-[11px] font-semibold uppercase hover:bg-red-500 hover:text-white transition">
                            Batalkan
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4">
                        <span class="block font-semibold text-gray-800">10 April 2026</span>
                        <span class="text-xs text-gray-400">9:00 WIB</span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="font-medium text-gray-700">Dr. Fenni</span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-600 uppercase">
                            Selesai
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <a href="{{ route('pasien.riwayat-pembayaran') }}"
                            class="inline-flex px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-[11px] font-semibold uppercase hover:bg-blue-600 hover:text-white transition">
                            Lihat Struk
                        </a>
                    </td>

                    <td class="px-5 py-4">
                        <a href="{{ route('pasien.rekam-medis.detail', 2) }}"
                            class="inline-flex px-4 py-2 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-semibold uppercase hover:bg-indigo-600 hover:text-white transition">
                            Rekam Medis
                        </a>
                    </td>

                    <td class="px-5 py-4 text-center text-gray-300">
                        —
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4">
                        <span class="block font-semibold text-gray-400">08 April 2026</span>
                        <span class="text-xs text-gray-300">10:00 WIB</span>
                    </td>

                    <td class="px-5 py-4">
                        <span class="font-medium text-gray-400">Dr. Siti</span>
                    </td>

                    <td class="px-5 py-4">
                        <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold bg-red-50 text-red-400 uppercase">
                            Dibatalkan
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <span class="text-xs italic text-gray-400">
                            Refunded
                        </span>
                    </td>

                    <td class="px-5 py-4 text-center text-gray-300">
                        —
                    </td>

                    <td class="px-5 py-4 text-center">
                     {{-- Ganti button ke tag 'a' agar bisa navigasi ke halaman lain --}}
                        <a href="{{ route('pasien.buat-janji') }}" class="inline-flex px-4 py-2 rounded-full bg-emerald-50 text-emerald-600 text-[11px] font-semibold uppercase hover:bg-emerald-500 hover:text-white transition decoration-none">
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
            <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed transition hover:bg-slate-50">Sebelumnya</button>
            <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed transition hover:bg-slate-50">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection