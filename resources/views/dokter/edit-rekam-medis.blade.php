@extends('dokter.layouts.dokter')
@section('title', 'Input Rekam Medis')

@section('content')
<div class="bg-white p-10 rounded-[30px] border border-slate-100 shadow-sm max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-start mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Input Rekam Medis</h2>
            <p class="text-slate-400 text-sm mt-1">
                Jadwal #{{ $jadwal->id }} &mdash; {{ $jadwal->tanggal->translatedFormat('d F Y') }}, {{ $jadwal->jam_format }} WIB
            </p>
        </div>
        <a href="{{ route('dokter.jadwal') }}"
           class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-all text-xs uppercase">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 rounded-2xl border border-red-100">
        <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('dokter.rekam-medis.store', $jadwal->id) }}" method="POST">
        @csrf

        {{-- Info Pasien & Dokter --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-6 bg-slate-50 rounded-2xl">
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Pasien</label>
                <p class="mt-1 font-bold text-slate-800">
                    {{ $jadwal->pasien->user->nama ?? '-' }}
                </p>
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Dokter Pemeriksa</label>
                <p class="mt-1 font-bold text-slate-800">
                    {{ $jadwal->dokter->user->nama ?? '-' }}
                </p>
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Konsultasi</label>
                <p class="mt-1 font-bold text-slate-800">
                    {{ $jadwal->tanggal->translatedFormat('d F Y') }}
                </p>
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Jam</label>
                <p class="mt-1 font-bold text-slate-800">
                    {{ $jadwal->jam_format ?? '-' }} WIB
                </p>
            </div>
            @if($jadwal->pasien && $jadwal->pasien->alergi && $jadwal->pasien->alergi->count())
            <div class="md:col-span-2">
                <label class="text-[10px] font-black text-red-400 uppercase tracking-widest">⚠ Riwayat Alergi Pasien</label>
                <p class="mt-1 font-semibold text-red-600 text-sm">
                    {{ $jadwal->pasien->alergi->pluck('nama_alergi')->join(', ') }}
                </p>
            </div>
            @endif
        </div>

        {{-- Keluhan & Diagnosa --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-slate-50 p-6 rounded-2xl">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Keluhan Pasien <span class="text-red-400">*</span></label>
                <textarea name="keluhan" rows="4"
                    class="w-full bg-white border border-slate-200 rounded-xl p-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400 transition resize-none"
                    placeholder="Keluhan yang dirasakan pasien…" required>{{ old('keluhan') }}</textarea>
            </div>
            <div class="bg-slate-50 p-6 rounded-2xl">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Diagnosa <span class="text-red-400">*</span></label>
                <textarea name="diagnosa" rows="4"
                    class="w-full bg-white border border-slate-200 rounded-xl p-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400 transition resize-none"
                    placeholder="Hasil diagnosa dokter…" required>{{ old('diagnosa') }}</textarea>
            </div>
        </div>

        {{-- Catatan --}}
        <div class="mb-8">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Catatan Tambahan</label>
            <div class="border border-slate-100 rounded-2xl p-1">
                <textarea name="catatan" rows="3"
                    class="w-full bg-white rounded-xl p-4 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400 transition resize-none border-none"
                    placeholder="Catatan medis tambahan (opsional)…">{{ old('catatan') }}</textarea>
            </div>
        </div>

        {{-- Resep Obat --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Resep Obat</label>
                <button type="button" id="btn-tambah-resep"
                    class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-all border border-emerald-200">
                    <i class="fa-solid fa-plus"></i> Tambah Obat
                </button>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                <table class="w-full text-sm" id="tabel-resep">
                    <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <tr>
                            <th class="px-5 py-4 text-left">Nama Obat</th>
                            <th class="px-5 py-4 text-left">Dosis</th>
                            <th class="px-5 py-4 text-left">Aturan Pakai</th>
                            <th class="px-5 py-4 text-center w-12"></th>
                        </tr>
                    </thead>
                    <tbody id="resep-body" class="divide-y divide-slate-50">
                        {{-- Row pertama --}}
                        <tr class="resep-row">
                            <td class="px-4 py-3">
                                <input type="text" name="resep[0][obat]" value="{{ old('resep.0.obat') }}"
                                    placeholder="Nama obat…"
                                    class="w-full bg-slate-50 rounded-xl px-3 py-2.5 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400/30 border border-transparent focus:border-emerald-400 transition">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="resep[0][dosis]" value="{{ old('resep.0.dosis') }}"
                                    placeholder="cth: 500 mg"
                                    class="w-full bg-slate-50 rounded-xl px-3 py-2.5 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400/30 border border-transparent focus:border-emerald-400 transition">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="resep[0][aturan_pakai]" value="{{ old('resep.0.aturan_pakai') }}"
                                    placeholder="cth: 3×1 sesudah makan"
                                    class="w-full bg-slate-50 rounded-xl px-3 py-2.5 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400/30 border border-transparent focus:border-emerald-400 transition">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" class="btn-hapus-resep text-slate-300 hover:text-red-400 transition-colors hidden">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-slate-400 mt-2 ml-1">Biarkan kosong jika tidak ada resep obat.</p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('dokter.jadwal') }}"
               class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">
                Batal
            </a>
            <button type="submit"
                class="px-8 py-3 bg-emerald-500 text-white rounded-xl text-sm font-bold hover:bg-emerald-600 shadow-sm transition-all flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Rekam Medis
            </button>
        </div>
    </form>
</div>

<script>
(function () {
    let rowIndex = 1;

    const tbody = document.getElementById('resep-body');
    const btnTambah = document.getElementById('btn-tambah-resep');

    function updateDeleteButtons() {
        const rows = tbody.querySelectorAll('.resep-row');
        rows.forEach(row => {
            const btn = row.querySelector('.btn-hapus-resep');
            btn.classList.toggle('hidden', rows.length === 1);
        });
    }

    function makeRow(idx) {
        const tr = document.createElement('tr');
        tr.classList.add('resep-row');
        tr.innerHTML = `
            <td class="px-4 py-3">
                <input type="text" name="resep[${idx}][obat]" placeholder="Nama obat…"
                    class="w-full bg-slate-50 rounded-xl px-3 py-2.5 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400/30 border border-transparent focus:border-emerald-400 transition">
            </td>
            <td class="px-4 py-3">
                <input type="text" name="resep[${idx}][dosis]" placeholder="cth: 500 mg"
                    class="w-full bg-slate-50 rounded-xl px-3 py-2.5 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400/30 border border-transparent focus:border-emerald-400 transition">
            </td>
            <td class="px-4 py-3">
                <input type="text" name="resep[${idx}][aturan_pakai]" placeholder="cth: 3×1 sesudah makan"
                    class="w-full bg-slate-50 rounded-xl px-3 py-2.5 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400/30 border border-transparent focus:border-emerald-400 transition">
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="btn-hapus-resep text-slate-300 hover:text-red-400 transition-colors">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </td>
        `;
        tr.querySelector('.btn-hapus-resep').addEventListener('click', function () {
            tr.remove();
            updateDeleteButtons();
        });
        return tr;
    }

    btnTambah.addEventListener('click', function () {
        tbody.appendChild(makeRow(rowIndex++));
        updateDeleteButtons();
    });

    // Wire up existing first-row delete button
    tbody.querySelectorAll('.btn-hapus-resep').forEach(btn => {
        btn.addEventListener('click', function () {
            btn.closest('.resep-row').remove();
            updateDeleteButtons();
        });
    });

    updateDeleteButtons();
})();
</script>
@endsection