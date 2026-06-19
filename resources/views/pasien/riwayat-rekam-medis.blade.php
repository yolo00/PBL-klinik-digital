@extends('pasien.layouts.app')
@section('title', 'Riwayat Rekam Medis Pasien')
@section('content')

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
        @foreach($rekamMedis as $item)
        <tr class="hover:bg-slate-50/80 transition-all duration-200">
            {{-- Tanggal & Waktu --}}
            <td class="px-8 py-6">
                <div class="text-lg font-bold text-slate-800">
                    {{ \Carbon\Carbon::parse($item->jadwal->tanggal)->translatedFormat('d F Y') }}
                </div>
                <div class="text-sm text-slate-400 font-medium mt-0.5">
                    {{ $item->jadwal->jam }}:00 WIB
                </div>
            </td>
            
            {{-- Dokter --}}
            <td class="px-8 py-6">
                <div class="text-base font-bold text-slate-700">
                    {{ $item->jadwal->dokter->user->nama ?? 'Nama Dokter Tidak Ditemukan' }}
                </div>
                <div class="text-xs text-slate-400 mt-0.5 uppercase tracking-wide font-semibold">
                    {{ $item->jadwal->dokter->spesialisasi->nama_spesialisasi ?? 'DOKTER UMUM' }}
                </div>
            </td>

            {{-- Diagnosa --}}
            <td class="px-8 py-6">
                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 uppercase border border-blue-100 shadow-sm">
                    {{ $item->diagnosa ?? 'Belum ada diagnosa' }}
                </span>
            </td>

            {{-- Aksi --}}
            <td class="px-8 py-6 text-center">
                <a href="{{ route('pasien.rekam-medis.detail', $item->id) }}" 
                   class="inline-flex px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold uppercase hover:bg-emerald-700 transition shadow-sm">
                    Lihat Detail
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
        </div>
        
        <div class="p-8 bg-slate-50 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-sm font-medium text-slate-500">Menampilkan <span class="text-slate-900 font-bold">1 - {{ count($rekamMedis) }}</span> dari <span class="text-slate-900 font-bold">{{ count($rekamMedis) }}</span> Rekam Medis</span>
            <div class="flex gap-3">
                <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed transition hover:bg-slate-50">Sebelumnya</button>
                <button class="px-5 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed transition hover:bg-slate-50">Selanjutnya</button>
            </div>
        </div>
    </div>
</div>
@endsection