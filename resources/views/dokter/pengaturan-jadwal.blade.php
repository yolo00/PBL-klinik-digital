@extends('dokter.layouts.dokter')
@section('title', 'Pengaturan Jadwal')

@section('content')
@php
    \Carbon\Carbon::setLocale('id');
@endphp
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

    {{-- Desktop/Table --}}
    <div class="hidden lg:block overflow-x-auto">
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

    {{-- Mobile Card List --}}
    <div class="lg:hidden p-4">
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-4 mb-3 hover:shadow-lg transition-all duration-300">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hari</p>
            <p class="text-slate-700 font-semibold mt-1">Senin – Kamis</p>

            <div class="mt-3 grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jam Mulai</p>
                    <p class="text-blue-600 font-bold mt-1">08.00</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jam Selesai</p>
                    <p class="text-slate-700 font-semibold mt-1">17.00</p>
                </div>
            </div>

            <div class="mt-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Istirahat</p>
                <p class="text-center text-slate-400 mt-1">12.00 – 13.00</p>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-4 mb-3 hover:shadow-lg transition-all duration-300">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hari</p>
            <p class="text-slate-700 font-semibold mt-1">Jumat</p>

            <div class="mt-3 grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jam Mulai</p>
                    <p class="text-blue-600 font-bold mt-1">08.00</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jam Selesai</p>
                    <p class="text-slate-700 font-semibold mt-1">17.00</p>
                </div>
            </div>

            <div class="mt-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Istirahat</p>
                <p class="text-center text-slate-400 mt-1">12.00 – 14.00</p>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-4 hover:shadow-lg transition-all duration-300">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hari</p>
            <p class="text-slate-700 font-semibold mt-1">Sabtu</p>

            <div class="mt-3 grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jam Mulai</p>
                    <p class="text-blue-600 font-bold mt-1">10.00</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jam Selesai</p>
                    <p class="text-slate-700 font-semibold mt-1">14.00</p>
                </div>
            </div>

            <div class="mt-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Istirahat</p>
                <p class="text-center text-slate-400 mt-1">12.00 – 13.00</p>
            </div>
        </div>
    </div>
</div>

{{-- Riwayat Pengajuan Cuti --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-2">
        <i class="fa-solid fa-clock-rotate-left text-blue-500 text-sm"></i>
        <h2 class="font-bold text-slate-700 text-sm uppercase tracking-wider">Riwayat Pengajuan Cuti</h2>
    </div>

    {{-- Desktop/Table --}}
    <div class="hidden lg:block overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left">Dari Tanggal</th>
                    <th class="text-left">Sampai Tanggal</th>
                    <th class="text-left">Alasan</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cutis ?? [] as $cuti)
                    <tr>
                        <td class="font-semibold text-slate-700">
                            {{ \Carbon\Carbon::parse($cuti->dari_tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="font-semibold text-slate-700">
                            {{ \Carbon\Carbon::parse($cuti->sampai_tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="text-slate-500">{{ $cuti->alasan ?? '-' }}</td>
                        <td class="text-center">
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-xs font-bold border border-slate-100 bg-slate-50 {{ $cuti->status_color }}">
                                {{ $cuti->status_label }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-10 text-center text-slate-400 text-sm">Belum ada pengajuan cuti.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(isset($cutis) && $cutis->hasPages())
            <div class="px-4 py-4">
                {{ $cutis->links() }}
            </div>
        @endif
    </div>

    {{-- Mobile Card List --}}
    <div class="lg:hidden p-4">
        @forelse($cutis ?? [] as $cuti)
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-4 mb-3 hover:shadow-lg transition-all duration-300">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Dari Tanggal</p>
                        <p class="text-slate-700 font-semibold mt-1">
                            {{ \Carbon\Carbon::parse($cuti->dari_tanggal)->translatedFormat('d F Y') }}
                        </p>

                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-3">Sampai Tanggal</p>
                        <p class="text-slate-700 font-semibold mt-1">
                            {{ \Carbon\Carbon::parse($cuti->sampai_tanggal)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-xs font-bold border border-slate-100 bg-slate-50 {{ $cuti->status_color }} shrink-0">
                        {{ $cuti->status_label }}
                    </span>
                </div>

                <div class="mt-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Alasan</p>
                    <p class="text-slate-500 mt-1 break-words">
                        {{ $cuti->alasan ?? '-' }}
                    </p>
                </div>
            </div>
        @empty
            <div class="py-10">
                <div class="flex flex-col items-center gap-2">
                    <i class="fa-solid fa-folder-open text-4xl text-slate-200"></i>
                    <p class="text-sm font-medium text-slate-400">
                        Belum ada pengajuan cuti.
                    </p>
                </div>
            </div>
        @endforelse

        @if(isset($cutis) && $cutis->hasPages())
            <div class="pt-2">
                {{ $cutis->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Form Pengajuan Cuti --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 transition-all duration-300 hover:shadow-lg">
    <div class="flex items-center gap-2 mb-6">
        <i class="fa-solid fa-paper-plane text-blue-500 text-sm"></i>
        <h2 class="font-bold text-slate-700 text-sm uppercase tracking-wider">Form Pengajuan Cuti</h2>
    </div>

    <form action="{{ route('dokter.pengaturan.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Tanggal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Tanggal Mulai</label>
                <div class="relative group">
                    <i class="fa-solid fa-calendar-plus absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-500 transition-colors text-sm"></i>
                    <input type="date" name="dari_tanggal" min="{{ now()->toDateString() }}"
                        class="w-full pl-11 pr-5 py-3 bg-slate-50 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Sampai Tanggal</label>
                <div class="relative group">
                    <i class="fa-solid fa-calendar-check absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-500 transition-colors text-sm"></i>
                    <input type="date" name="sampai_tanggal" min="{{ now()->toDateString() }}"
                        class="w-full pl-11 pr-5 py-3 bg-slate-50 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                </div>
                <p class="text-[10px] text-slate-400 italic">* Kosongkan jika hanya cuti sehari</p>
            </div>
        </div>

        {{-- Alasan --}}
        <div class="space-y-2">
            <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Alasan Pengajuan <span class="text-red-400">(Opsional)</span></label>
            <textarea name="alasan" rows="4" placeholder="Tuliskan alasan pengajuan cuti Anda di sini..."
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
