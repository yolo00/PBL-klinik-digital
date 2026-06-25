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
    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-medium shadow-sm">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden">

        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input id="searchInput" type="text" placeholder="Cari dokter atau tanggal..."
                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-base focus:ring-2 focus:ring-emerald-500 transition shadow-sm">
            </div>
            <select id="filterStatus" class="w-full md:w-48 bg-slate-50 border-none rounded-2xl text-base text-slate-600 focus:ring-2 focus:ring-emerald-500 py-3.5 px-4 shadow-sm cursor-pointer">
                <option value="">Semua Status</option>
                <option value="menunggu">Mendatang</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left" id="jadwalTable">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Tanggal & Waktu</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Dokter</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Status Jadwal</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest">Pembayaran</th>
                        <th class="px-8 py-5 text-sm font-bold uppercase text-slate-400 tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="jadwalBody">
                    @forelse($riwayatJadwal as $jadwal)
                    
                    {{-- Definisikan status pembayaran di awal agar tidak bocor antar baris --}}
                    @php
                        $p         = $jadwal->pembayaran;
                        $isQris    = $p && $p->metode === 'qris';
                        $isPending = $p && $p->status === 'pending';
                        $isLunas   = $p && $p->status === 'lunas';
                        $isBatal   = $p && $p->status === 'batal';
                    @endphp

                    <tr class="hover:bg-slate-50/80 transition-all duration-200"
                        data-dokter="{{ strtolower($jadwal->dokter->user->nama ?? '') }}"
                        data-tanggal="{{ $jadwal->tanggal }}"
                        data-status="{{ $jadwal->status }}">

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
                            <div class="text-base font-bold text-slate-700">
                                {{ $jadwal->dokter->user->nama ?? 'Dokter Tidak Terdaftar' }}
                            </div>
                            @if($jadwal->dokter && $jadwal->dokter->spesialisasi)
                            <div class="text-xs text-slate-400 mt-0.5">{{ $jadwal->dokter->spesialisasi->nama }}</div>
                            @endif
                        </td>

                        {{-- Status Jadwal --}}
                        <td class="px-8 py-6">
                            @if($jadwal->status == 'menunggu')
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 uppercase border border-blue-100 shadow-sm">Mendatang</span>
                            @elseif($jadwal->status == 'selesai')
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-gray-600 uppercase border border-slate-200 shadow-sm">Selesai</span>
                            @elseif($jadwal->status == 'dikonfirmasi')
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 uppercase border border-emerald-100 shadow-sm">Dikonfirmasi</span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-400 uppercase border border-red-100 shadow-sm">Dibatalkan</span>
                            @endif
                        </td>

                        {{-- Pembayaran --}}
                        <td class="px-8 py-6">
                            @if($p)
                                <div class="text-sm font-bold text-slate-800">
                                    Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                </div>
                                <div class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold mb-2">
                                    {{ $p->metode === 'qris' ? 'QRIS' : 'Cash' }}
                                </div>

                                @if($isQris && $isPending)
                                    <a href="{{ route('pasien.pembayaran.qris', $p->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-500 text-white text-[11px] font-bold uppercase hover:bg-emerald-600 transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6.364 1.636l-.707.707M20 12h-1M17.657 17.657l-.707-.707M12 20v-1m-5.657-1.636l.707-.707M4 12H3m2.343-5.657l.707.707"/>
                                        </svg>
                                        Bayar QRIS
                                    </a>
                                @elseif($isQris && $isLunas)
                                    <a href="{{ route('pasien.pembayaran.struk', $p->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-[11px] font-bold uppercase border border-emerald-200 hover:bg-emerald-500 hover:text-white transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Lunas · Lihat Struk
                                    </a>
                                @elseif(!$isQris && $isPending)
                                    <span class="inline-flex px-3 py-1 rounded-lg bg-amber-50 text-amber-600 text-[10px] font-bold uppercase border border-amber-200">
                                        Belum Dibayar
                                    </span>
                                @elseif(!$isQris && $isLunas)
                                    <span class="inline-flex px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase border border-emerald-200">
                                        ✓ Lunas
                                    </span>
                                @elseif($isBatal)
                                    <span class="inline-flex px-3 py-1 rounded-lg bg-red-50 text-red-500 text-[10px] font-bold uppercase border border-red-200">
                                        Batal
                                    </span>
                                @endif
                            @else
                                <span class="text-slate-300 text-sm italic">Belum ada</span>
                            @endif
                        </td>

{{-- Aksi --}}
                        <td class="px-8 py-6 text-center">
                            @if($jadwal->status == 'menunggu')
                                {{-- Logika H-1: Tombol muncul hanya jika tanggal jadwal > besok --}}
                                @if(\Carbon\Carbon::parse($jadwal->tanggal)->gt(\Carbon\Carbon::now()->addDay()))
                                    <form action="{{ route('pasien.batal_jadwal', $jadwal->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin membatalkan jadwal ini? Pembatalan hanya bisa dilakukan H-1.')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex px-4 py-2.5 rounded-xl bg-red-50 text-red-500 text-xs font-bold uppercase hover:bg-red-500 hover:text-white transition shadow-sm">
                                            Batalkan
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex px-4 py-2.5 rounded-xl bg-slate-100 text-slate-400 text-xs font-bold uppercase cursor-not-allowed">
                                        Tidak dapat dibatalkan
                                    </span>
                                @endif

                            @elseif($jadwal->status == 'dibatalkan')
                                <a href="{{ route('pasien.buat-janji') }}"
                                    class="inline-flex px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 text-xs font-bold uppercase border border-emerald-100 hover:bg-emerald-500 hover:text-white transition shadow-sm">
                                    Pesan Lagi
                                </a>
                            @elseif($jadwal->status == 'selesai' && $isLunas)
                                <span class="inline-flex px-4 py-2.5 rounded-xl bg-slate-50 text-slate-500 text-xs font-bold uppercase border border-slate-200 shadow-sm cursor-default">
                                    Selesai
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium">
                            Belum ada riwayat jadwal janji temu yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            <span class="text-sm font-medium text-slate-500">
                Total: <span class="text-slate-900 font-bold" id="totalCount">{{ $riwayatJadwal->count() }}</span> Jadwal Terdaftar
            </span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ─── Client-side search + filter ─────────────────────────
    const searchInput  = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const rows         = document.querySelectorAll('#jadwalBody tr[data-status]');
    const totalCount   = document.getElementById('totalCount');

    function applyFilter() {
        const q      = searchInput.value.toLowerCase();
        const status = filterStatus.value;
        let visible  = 0;

        rows.forEach(row => {
            const matchSearch = !q
                || row.dataset.dokter.includes(q)
                || row.dataset.tanggal.includes(q);
            const matchStatus = !status || row.dataset.status === status;

            if (matchSearch && matchStatus) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        totalCount.textContent = visible;
    }

    searchInput.addEventListener('input', applyFilter);
    filterStatus.addEventListener('change', applyFilter);
</script>
@endpush
@endsection