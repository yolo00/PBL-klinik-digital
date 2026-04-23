@extends('admin.layouts.app')
@section('title', 'Jadwal Sistem & Cuti Dokter')
@section('content')
<div class="space-y-8">
    <!-- Jam Operasional (statis — info klinik) -->
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="mb-6 border-b border-slate-100 pb-4">
            <h2 class="text-[20px] font-bold text-slate-800">Jam Operasional Klinik</h2>
            <p class="text-[14px] text-slate-500 mt-1">Jadwal operasional sistem klinik.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-slate-50 rounded-[16px] border border-slate-100 text-center">
                <p class="text-[14px] font-bold text-slate-700 mb-1">Senin – Jumat</p>
                <p class="text-[16px] font-semibold text-slate-900">08:00 – 20:00</p>
            </div>
            <div class="p-4 bg-slate-50 rounded-[16px] border border-slate-100 text-center">
                <p class="text-[14px] font-bold text-slate-700 mb-1">Sabtu</p>
                <p class="text-[16px] font-semibold text-slate-900">08:00 – 15:00</p>
            </div>
            <div class="p-4 bg-rose-50 rounded-[16px] border border-rose-100 text-center">
                <p class="text-[14px] font-bold text-rose-700 mb-1">Minggu</p>
                <p class="text-[16px] font-semibold text-rose-900">Tutup</p>
            </div>
        </div>
    </div>

    <!-- Tabel Cuti Dokter -->
    <div class="bg-gray-200/50 rounded-[32px] overflow-hidden p-8">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h2 class="text-[20px] font-bold text-slate-800">Pengajuan Cuti Dokter</h2>
        </div>

        <div class="overflow-x-auto bg-white rounded-[24px] shadow-sm border border-slate-100 px-2 py-2">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[14px] text-slate-600 font-medium border-b border-gray-100">
                        <th class="px-6 py-5">Nama Dokter</th>
                        <th class="px-6 py-5">Dari Tanggal</th>
                        <th class="px-6 py-5">Sampai Tanggal</th>
                        <th class="px-6 py-5">Alasan</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-gray-100">
                    @forelse($cutiDokters as $cuti)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5 align-middle font-medium">{{ $cuti->dokter->dr_name }}</td>
                        <td class="px-6 py-5 align-middle">{{ $cuti->dari_tanggal->format('d M Y') }}</td>
                        <td class="px-6 py-5 align-middle">{{ $cuti->sampai_tanggal->format('d M Y') }}</td>
                        <td class="px-6 py-5 align-middle text-slate-600">{{ $cuti->alasan }}</td>
                        <td class="px-6 py-5 align-middle font-bold {{ $cuti->status_color }}">{{ $cuti->status_label }}</td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.cuti-dokter.detail', $cuti->id_cuti) }}"
                                    class="px-5 py-2 rounded-full bg-gray-200 hover:bg-slate-100 hover:text-slate-700 text-slate-700 text-[13px] transition-colors shadow-sm">Lihat</a>

                                @if($cuti->status === 'pending')
                                <form action="{{ route('admin.cuti-dokter.terima', $cuti->id_cuti) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-5 py-2 rounded-full bg-emerald-100 hover:bg-emerald-200 text-emerald-700 text-[13px] font-bold transition-colors shadow-sm">Terima</button>
                                </form>
                                <form action="{{ route('admin.cuti-dokter.tolak', $cuti->id_cuti) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-5 py-2 rounded-full bg-rose-100 hover:bg-rose-200 text-rose-700 text-[13px] font-bold transition-colors shadow-sm">Tolak</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-400 text-[14px]">Belum ada pengajuan cuti dokter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-6 border-t border-gray-100 flex items-center justify-between gap-4 bg-gray-200/50 rounded-b-[24px]">
                <span class="text-[14px] text-slate-500">Total {{ $cutiDokters->total() }} pengajuan</span>
                <div>{{ $cutiDokters->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
