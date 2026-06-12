@extends('pasien.layouts.app')
@section('title', 'Riwayat Jadwal')
@section('content')

<div class="animate-fade-in px-4 py-6 md:px-8">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Jadwal</h1>
        <p class="text-lg text-slate-500 mt-2">Melihat daftar janji Anda sebelumnya dan yang akan datang.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-medium shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden">
        
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
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
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
                    @forelse($riwayatJadwal as $jadwal)
                    <tr class="hover:bg-slate-50/80 transition-all duration-200">
                        {{-- Tanggal & Waktu --}}
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->translatedFormat('d F Y') }}
                            </div>
                            <div class="text-sm text-slate-400 font-medium mt-0.5">
                                {{ $jadwal->jam }}:00 WIB
                            </div>
                        </td>

                        {{-- Dokter --}}
                        <td class="px-8 py-6">
                            <div class="text-lg font-bold text-slate-700">
                                {{ $jadwal->dokter->user->nama ?? 'Dokter Tidak Terdaftar' }}
                            </div>
                        </td>

                        {{-- Status Jadwal --}}
                        <td class="px-8 py-6">
                            @if($jadwal->status == 'menunggu')
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 uppercase border border-blue-100 shadow-sm">Mendatang</span>
                            @elseif($jadwal->status == 'selesai')
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-gray-600 uppercase border border-slate-200 shadow-sm">Selesai</span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-400 uppercase border border-red-100 shadow-sm">Dibatalkan</span>
                            @endif
                        </td>

                        {{-- Pembayaran --}}
                        <td class="px-8 py-6">
                            @if($jadwal->pembayaran)
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800">
                                        Rp {{ number_format($jadwal->pembayaran->jumlah, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold">
                                        {{ $jadwal->pembayaran->metode }}
                                    </span>
                                </div>

                                {{-- Logika Tombol --}}
                                <div class="mt-2">
                                    @if($jadwal->pembayaran->status == 'pending')
                                        <span class="inline-flex px-3 py-1 rounded-lg bg-yellow-100 text-yellow-600 text-[10px] font-bold uppercase">
                                            Menunggu
                                        </span>
                                    @elseif($jadwal->pembayaran->status == 'lunas')
                                        <span class="text-emerald-600 font-bold text-xs">Lunas</span>
                                    @elseif($jadwal->pembayaran->status == 'batal')
                                        <span class="text-red-600 font-bold text-xs">Batal</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-slate-300 text-sm italic">Belum ada</span>
                            @endif
                        </td>

                        {{-- Akses Rekam Medis --}}
                        <td class="px-8 py-6">
                            @if($jadwal->status == 'selesai')
                                <a href="{{ route('pasien.rekam-medis.detail', $jadwal->id) }}"
                                    class="inline-flex px-4 py-2.5 rounded-xl bg-indigo-50 text-indigo-600 text-xs font-bold uppercase border border-indigo-100 hover:bg-indigo-600 hover:text-white transition shadow-sm">
                                    Rekam Medis
                                </a>
                            @else
                                <button disabled class="inline-flex px-4 py-2.5 rounded-xl bg-gray-100 text-gray-400 text-xs font-bold uppercase cursor-not-allowed">
                                    Belum Tersedia
                                </button>
                            @endif
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="px-8 py-6 text-center">
                            @if($jadwal->status == 'menunggu')
                                <form action="{{ route('pasien.batal_jadwal', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan jadwal janji temu ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex px-4 py-2.5 rounded-xl bg-red-50 text-red-500 text-xs font-bold uppercase hover:bg-red-500 hover:text-white transition shadow-sm">
                                        Batalkan
                                    </button>
                                </form>
                            @elseif($jadwal->status == 'dibatalkan')
                                <a href="{{ route('pasien.buat-janji') }}" class="inline-flex px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 text-xs font-bold uppercase border border-emerald-100 hover:bg-emerald-500 hover:text-white transition shadow-sm">
                                    Pesan Lagi
                                </a>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-slate-400 font-medium">
                            Belum ada riwayat jadwal janji temu yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-sm font-medium text-slate-500">
                Total: <span class="text-slate-900 font-bold">{{ $riwayatJadwal->count() }}</span> Jadwal Terdaftar
            </span>
        </div>
    </div>
</div>

@endsection