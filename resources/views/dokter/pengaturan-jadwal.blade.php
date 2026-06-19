@extends('dokter.layouts.dokter')
@section('title', 'Pengaturan Jadwal')
@section('breadcrumb', 'Pengaturan — Jadwal & Cuti')

@section('content')
<div class="mb-7">
    <h1 class="text-2xl font-bold text-slate-800">Pengaturan Jadwal</h1>
    <p class="text-slate-500 text-sm mt-1">Atur jadwal operasional dan pengajuan cuti Anda.</p>
</div>

{{-- Jadwal Praktik Rutin --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-2">
        <i class="fa-solid fa-calendar-week text-blue-500 text-sm"></i>
        <h2 class="font-bold text-slate-700 text-sm uppercase tracking-wider">Jadwal Praktik Rutin</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">Hari</th>
                    <th class="text-left">Jam Mulai</th>
                    <th class="text-center">Istirahat</th>
                    <th class="text-right">Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-semibold text-slate-700">Senin – Kamis</td>
                    <td class="font-bold text-blue-600">08.00</td>
                    <td class="text-center text-slate-400">12.00 – 13.00</td>
                    <td class="text-right font-semibold text-slate-700">17.00</td>
                </tr>
                <tr>
                    <td class="font-semibold text-slate-700">Jumat</td>
                    <td class="font-bold text-blue-600">08.00</td>
                    <td class="text-center text-slate-400">12.00 – 14.00</td>
                    <td class="text-right font-semibold text-slate-700">17.00</td>
                </tr>
                <tr>
                    <td class="font-semibold text-slate-700">Sabtu</td>
                    <td class="font-bold text-blue-600">10.00</td>
                    <td class="text-center text-slate-400">12.00 – 13.00</td>
                    <td class="text-right font-semibold text-slate-700">14.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Riwayat Pengajuan Cuti --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-2">
        <i class="fa-solid fa-clock-rotate-left text-blue-500 text-sm"></i>
        <h2 class="font-bold text-slate-700 text-sm uppercase tracking-wider">Riwayat Pengajuan Cuti</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">Dari Tanggal</th>
                    <th class="text-left">Sampai Tanggal</th>
                    <th class="text-left">Alasan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contoh data statis, ganti dengan @forelse jika sudah dinamis --}}
                <tr>
                    <td class="font-semibold text-slate-700">30 Maret 2026</td>
                    <td class="font-semibold text-slate-700">30 Maret 2026</td>
                    <td class="text-slate-500">Keperluan keluarga</td>
                    <td class="text-center">
                        <span class="badge-selesai">Disetujui</span>
                    </td>
                    <td class="text-center">
                        <div class="flex justify-center gap-2">
                            <button class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition-all">
                                Lihat
                            </button>
                            <button class="px-3 py-1.5 bg-red-50 text-red-500 rounded-lg text-xs font-semibold hover:bg-red-100 transition-all">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                {{-- Jika tidak ada data:
                <tr>
                    <td colspan="5" class="py-10 text-center text-slate-400 text-sm">Belum ada pengajuan cuti.</td>
                </tr>
                --}}
            </tbody>
        </table>
    </div>
</div>

{{-- Form Pengajuan Cuti --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
    <div class="flex items-center gap-2 mb-6">
        <i class="fa-solid fa-paper-plane text-blue-500 text-sm"></i>
        <h2 class="font-bold text-slate-700 text-sm uppercase tracking-wider">Form Pengajuan Cuti</h2>
    </div>

    <form action="#" method="POST" class="space-y-6">
        @csrf

        {{-- Tanggal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Tanggal Mulai</label>
                <div class="relative group">
                    <i class="fa-solid fa-calendar-plus absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-500 transition-colors text-sm"></i>
                    <input type="date"
                        class="w-full pl-11 pr-5 py-3 bg-slate-50 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Sampai Tanggal</label>
                <div class="relative group">
                    <i class="fa-solid fa-calendar-check absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-500 transition-colors text-sm"></i>
                    <input type="date"
                        class="w-full pl-11 pr-5 py-3 bg-slate-50 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                </div>
                <p class="text-[10px] text-slate-400 italic">* Kosongkan jika hanya cuti sehari</p>
            </div>
        </div>

        {{-- Alasan --}}
        <div class="space-y-2">
            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Alasan Pengajuan</label>
            <textarea rows="4" placeholder="Tuliskan alasan pengajuan cuti Anda di sini..."
                class="w-full px-5 py-3.5 bg-slate-50 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all resize-none"></textarea>
        </div>

        {{-- Footer --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-5 border-t border-slate-50">
            <div class="flex items-center gap-3 text-amber-600 bg-amber-50 px-5 py-3 rounded-xl border border-amber-100">
                <i class="fa-solid fa-circle-info text-sm shrink-0"></i>
                <p class="text-xs font-semibold">Mohon ajukan cuti minimal 3 hari sebelum tanggal pelaksanaan.</p>
            </div>
            <button type="submit"
                class="px-8 py-3 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-100 transition-all flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-paper-plane text-xs"></i> Ajukan Cuti
            </button>
        </div>
    </form>
</div>
@endsection