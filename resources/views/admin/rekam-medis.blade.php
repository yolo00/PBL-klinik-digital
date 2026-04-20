@extends('admin.layouts.app')

@section('title', 'Data Rekam Medis')

@section('content')
<div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">
    
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="text-[20px] font-bold text-slate-800">Cari Data Rekam Medis</h2>
        <button class="px-5 py-2.5 bg-emerald-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-emerald-600 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Data
        </button>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-4 mb-4">
        <input type="text" placeholder="Cari" class="flex-1 min-w-[200px] max-w-[600px] px-5 py-3 bg-white border border-slate-200 rounded-[12px] text-[14px] focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
        <select class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[150px] appearance-none cursor-pointer">
            <option>Status : -</option>
            <option>Rawat Jalan</option>
            <option>Rawat Inap</option>
        </select>
        <button class="px-6 py-3 bg-gray-400 text-white font-medium rounded-[12px] text-[14px] hover:bg-gray-500 transition-colors shadow-sm">Reset Filter</button>
    </div>

    <!-- Sub-filter -->
    <div class="mb-6">
        <select class="px-5 py-3 bg-gray-400 text-white font-medium border-0 rounded-[12px] text-[14px] focus:outline-none shadow-sm min-w-[200px] appearance-none cursor-pointer">
            <option>Sortir : Nama A - Z</option>
            <option>Sortir : Nama Z - A</option>
        </select>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                    <th class="px-6 py-5">Id</th>
                    <th class="px-6 py-5">Nama Pasien</th>
                    <th class="px-6 py-5">Dokter Pemeriksa</th>
                    <th class="px-6 py-5">Tanggal Masuk</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-center">Kelola</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 align-middle">045</td>
                    <td class="px-6 py-5 align-middle">Budi Prasetyo</td>
                    <td class="px-6 py-5 align-middle">Dr. Fenni</td>
                    <td class="px-6 py-5 align-middle">12 Mei 2026</td>
                    <td class="px-6 py-5 align-middle">Rawat Jalan</td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button class="px-5 py-2 rounded-full bg-gray-200 hover:bg-emerald-100 hover:text-emerald-700 text-slate-700 text-[13px] transition-colors shadow-sm">Lihat</button>
                            <button class="px-5 py-2 rounded-full bg-gray-200 hover:bg-blue-100 hover:text-blue-700 text-slate-700 text-[13px] transition-colors shadow-sm">Edit</button>
                            <button class="px-5 py-2 rounded-full bg-gray-200 hover:bg-rose-100 hover:text-rose-700 text-slate-700 text-[13px] transition-colors shadow-sm">Hapus</button>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 align-middle">046</td>
                    <td class="px-6 py-5 align-middle">Siti Aminah</td>
                    <td class="px-6 py-5 align-middle">Dr. Andi</td>
                    <td class="px-6 py-5 align-middle">14 Mei 2026</td>
                    <td class="px-6 py-5 align-middle">Rawat Inap</td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button class="px-5 py-2 rounded-full bg-gray-200 hover:bg-emerald-100 hover:text-emerald-700 text-slate-700 text-[13px] transition-colors shadow-sm">Lihat</button>
                            <button class="px-5 py-2 rounded-full bg-gray-200 hover:bg-blue-100 hover:text-blue-700 text-slate-700 text-[13px] transition-colors shadow-sm">Edit</button>
                            <button class="px-5 py-2 rounded-full bg-gray-200 hover:bg-rose-100 hover:text-rose-700 text-slate-700 text-[13px] transition-colors shadow-sm">Hapus</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="p-6 border-t border-gray-100 flex items-center justify-center gap-2 text-[14px] text-slate-600 font-bold bg-gray-200/50 rounded-b-[24px]">
            <button class="hover:text-emerald-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
            <span>Menunjukkan hasil 1 - 2 / 2</span>
            <button class="hover:text-emerald-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
        </div>
    </div>
</div>
@endsection
