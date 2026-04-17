@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6 max-w-[1400px] mx-auto">
    <!-- Statistic Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gray-200/50 rounded-[28px] p-6 border border-slate-100 flex flex-col items-center justify-center gap-3">
            <p class="text-[14px] text-slate-500 font-medium">Total Pasien</p>
            <p class="text-[36px] font-bold text-slate-800">79</p>
        </div>
        <div class="bg-gray-200/50 rounded-[28px] p-6 border border-slate-100 flex flex-col items-center justify-center gap-3">
            <p class="text-[14px] text-slate-500 font-medium">Total Dokter Aktif</p>
            <p class="text-[36px] font-bold text-slate-800">5</p>
        </div>
        <div class="bg-gray-200/50 rounded-[28px] p-6 border border-slate-100 flex flex-col items-center justify-center gap-3">
            <p class="text-[14px] text-slate-500 font-medium">Jadwal Hari Ini</p>
            <p class="text-[36px] font-bold text-slate-800">4</p>
        </div>
        <div class="bg-gray-200/50 rounded-[28px] p-6 border border-slate-100 flex flex-col items-center justify-center gap-3">
            <p class="text-[14px] text-slate-500 font-medium">Rekam Medis Baru</p>
            <p class="text-[36px] font-bold text-slate-800">6</p>
        </div>
    </div>

    <!-- Main Table Mockup Container -->
    <div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8 mt-6">
        <h2 class="text-[20px] font-bold text-slate-800 mb-6">Aktivitas Terkini</h2>
        <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                        <th class="px-6 py-5">Tipe Aktivitas</th>
                        <th class="px-6 py-5">Keterangan</th>
                        <th class="px-6 py-5">Waktu</th>
                        <th class="px-6 py-5">Status</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5 align-middle">Jadwal Baru</td>
                        <td class="px-6 py-5 align-middle">Aprillia Bunga dijadwalkan dengan Dr. Fenni</td>
                        <td class="px-6 py-5 align-middle text-slate-500">2 menit yang lalu</td>
                        <td class="px-6 py-5 align-middle text-emerald-600 font-bold">Terjadwal</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5 align-middle">Pembayaran</td>
                        <td class="px-6 py-5 align-middle">INV-202604-001 dari Aprillia Bunga</td>
                        <td class="px-6 py-5 align-middle text-slate-500">15 menit yang lalu</td>
                        <td class="px-6 py-5 align-middle text-emerald-600 font-bold">Lunas</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5 align-middle">Pendaftaran Baru</td>
                        <td class="px-6 py-5 align-middle">Budi Prasetyo mendaftar sebagai pasien baru</td>
                        <td class="px-6 py-5 align-middle text-slate-500">1 jam yang lalu</td>
                        <td class="px-6 py-5 align-middle text-emerald-600 font-bold">Sukses</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
