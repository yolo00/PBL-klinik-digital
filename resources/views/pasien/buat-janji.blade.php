@extends('pasien.layouts.app')
@section('title', 'Buat Janji Temu')
@section('content')

    <section class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2 tracking-tight">Buat Janji Temu</h1>
        <p class="text-gray-500 text-lg">Silakan pilih dokter, tanggal, waktu, dan metode pembayaran.</p>
    </section>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-2xl">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('pasien.store_jadwal') }}" method="POST" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-10">
        @csrf

        {{-- 1. Filter Spesialisasi --}}
        <div class="space-y-4">
            <label class="block text-lg font-bold text-gray-800">🩺 Pilih Jenis Dokter (Spesialisasi)</label>
            <select id="id_spesialisasi" class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl outline-none">
                <option value="all">Semua Spesialisasi / Jenis Dokter</option>
                @foreach($spesialisasis as $spesialis)
                    <option value="{{ $spesialis->id }}">
                        {{ $spesialis->nama ?? 'Spesialis' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 2. Pilih Dokter --}}
        <div class="space-y-4">
            <label class="block text-lg font-bold text-gray-800">👤 Pilih Dokter</label>
            <select name="id_dokter" id="id_dokter" class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl outline-none" required>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}"
                            data-price="{{ $dokter->spesialisasi->base_price > 0 ? $dokter->spesialisasi->base_price : 75000 }}">
                        {{ $dokter->user->nama ?? ($dokter->user->name ?? 'Dokter Tanpa Nama') }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- BAGIAN BARU: Informasi Riwayat Kesehatan Pasien (Sinkronisasi Profil) --}}
        <div class="space-y-4 p-6 bg-gray-50 rounded-2xl border border-gray-200">
            <label class="block text-lg font-bold text-gray-800">📋 Informasi Medis Pasien</label>
            
            @php
                $pasien = optional(auth()->user()->pasien);
                $riwayatPenyakit = $pasien->riwayat_penyakit;
                
                // Memastikan data alergi diparsing dengan aman baik berupa Collection, Array, maupun String
                if ($pasien->alergi instanceof \Illuminate\Support\Collection) {
                    $alergiText = $pasien->alergi->isNotEmpty() ? $pasien->alergi->pluck('nama_alergi')->implode(', ') : null;
                } elseif (is_array($pasien->alergi)) {
                    $alergiText = !empty($pasien->alergi) ? implode(', ', array_column($pasien->alergi, 'nama_alergi')) : null;
                } else {
                    $alergiText = $pasien->alergi;
                }
            @endphp

            {{-- KONDISI 1: Jika Kedua Data Belum Terisi (Pasien Baru) --}}
            @if(empty($riwayatPenyakit) && empty($alergiText))
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl mt-0.5 shrink-0">⚠️</span>
                        <div>
                            <h5 class="text-base font-bold text-amber-800">Data Medis Belum Lengkap</h5>
                            <p class="text-sm text-amber-700 mt-0.5">Anda belum mengisi riwayat penyakit dan alergi obat di profil. Mohon lengkapi demi keamanan diagnosis dokter.</p>
                        </div>
                    </div>
                    {{-- langsung diarahkan ke halaman edit profil --}}
                    <a href="{{ route('pasien.profil.edit') }}" class="inline-flex items-center justify-center bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold px-5 py-3 rounded-xl transition whitespace-nowrap shadow-md shadow-amber-100">
                        Lengkapi Profil Sekarang ➡️
                    </a>
                </div>

            {{-- KONDISI 2: Jika Data Sudah Terisi --}}
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Menampilkan Riwayat Penyakit --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Riwayat Penyakit</label>
                        <div class="text-base font-semibold text-gray-800 bg-white px-5 py-4 rounded-xl border border-gray-200 min-h-[50px]">
                            {{ $riwayatPenyakit ?? 'Tidak ada riwayat penyakit' }}
                        </div>
                    </div>

                    {{-- Menampilkan Data Alergi --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Alergi Obat / Makanan</label>
                        <div class="text-base font-semibold text-gray-800 bg-white px-5 py-4 rounded-xl border border-gray-200 min-h-[50px]">
                            {{ $alergiText ?? 'Tidak ada alergi' }}
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-400 italic">*Data di atas diambil otomatis dari profil Anda. Jika ada perubahan data medis terbaru, silakan perbarui melalui menu profil.</p>
            @endif
        </div>

        {{-- 3. Tanggal & Waktu --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="space-y-4">
                <label class="block text-lg font-bold text-gray-800">📅 Pilih Tanggal</label>
                <input type="date" name="tanggal" required
                       min="{{ date('Y-m-d') }}"
                       class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl outline-none">
            </div>
            <div class="space-y-4">
                <label class="block text-lg font-bold text-gray-800">⏰ Pilih Waktu</label>
                <select name="jam" class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl outline-none" required>
                    @for($i = 8; $i <= 16; $i++)
                        <option value="{{ $i }}">{{ $i }}:00 WIB</option>
                    @endfor
                </select>
            </div>
        </div>

        {{-- 4. Pilih Metode Pembayaran --}}
        <div class="space-y-4">
            <label class="block text-lg font-bold text-gray-800">💳 Metode Pembayaran</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Cash --}}
                <label id="label-cash"
                       class="metode-option flex items-center gap-5 p-6 rounded-2xl border-2 border-slate-200 bg-slate-50 cursor-pointer transition hover:border-slate-400 selected-metode">
                    <input type="radio" name="metode" value="cash" class="hidden" checked>
                    <div class="w-12 h-12 rounded-xl bg-slate-200 flex items-center justify-center text-2xl shrink-0">💵</div>
                    <div>
                        <p class="font-bold text-slate-800 text-base">Bayar di Klinik (Cash)</p>
                        <p class="text-sm text-slate-500 mt-0.5">Bayar langsung saat datang ke klinik</p>
                    </div>
                    <div class="ml-auto w-5 h-5 rounded-full border-2 border-slate-300 check-indicator flex items-center justify-center">
                        <div class="w-3 h-3 rounded-full bg-slate-500 hidden check-dot"></div>
                    </div>
                </label>

                {{-- QRIS --}}
                <label id="label-qris"
                       class="metode-option flex items-center gap-5 p-6 rounded-2xl border-2 border-slate-200 bg-slate-50 cursor-pointer transition hover:border-emerald-400">
                    <input type="radio" name="metode" value="qris" class="hidden">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-2xl shrink-0">📱</div>
                    <div>
                        <p class="font-bold text-slate-800 text-base">QRIS</p>
                        <p class="text-sm text-slate-500 mt-0.5">Scan QR & bayar langsung sekarang</p>
                    </div>
                    <div class="ml-auto w-5 h-5 rounded-full border-2 border-emerald-300 check-indicator flex items-center justify-center">
                        <div class="w-3 h-3 rounded-full bg-emerald-500 hidden check-dot"></div>
                    </div>
                </label>

            </div>
        </div>

        {{-- 5. Summary + Submit --}}
        <div class="pt-10 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center bg-gray-50 p-8 rounded-3xl gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1 font-medium">Biaya Konsultasi</p>
                <p class="text-3xl font-black text-gray-900" id="harga-display">Rp 75.000</p>
                <p class="text-xs text-gray-400 mt-1" id="metode-info">Bayar di klinik saat tiba</p>
            </div>
            <button type="submit"
                    class="w-full md:w-auto bg-emerald-600 text-white px-12 py-5 rounded-2xl font-bold text-lg hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100 flex items-center justify-center gap-3">
                📅 Daftar Jadwal Sekarang
            </button>
        </div>
    </form>

@push('scripts')
<script>
    // ─── Data harga awal dari dokter options ─────────────────
    function getSelectedPrice() {
        const opt = document.getElementById('id_dokter').selectedOptions[0];
        return opt ? parseInt(opt.dataset.price || 75000) : 75000;
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateHargaDisplay() {
        const harga  = getSelectedPrice();
        const metode = document.querySelector('input[name="metode"]:checked')?.value || 'cash';
        document.getElementById('harga-display').textContent = formatRupiah(harga);
        document.getElementById('metode-info').textContent  =
            metode === 'qris'
                ? 'Anda akan diarahkan ke halaman QR setelah daftar'
                : 'Bayar di klinik saat tiba';
    }

    // ─── Update UI saat dokter berganti ─────────────────────
    document.getElementById('id_dokter').addEventListener('change', updateHargaDisplay);

    // ─── Pilih metode ────────────────────────────────────────
    const metodeOptions = document.querySelectorAll('.metode-option');
    metodeOptions.forEach(label => {
        label.addEventListener('click', () => {
            // Uncheck semua
            metodeOptions.forEach(l => {
                l.classList.remove('selected-metode');
                l.classList.remove('border-emerald-500', 'bg-emerald-50', 'border-slate-500', 'bg-slate-100');
                l.classList.add('border-slate-200', 'bg-slate-50');
                l.querySelector('.check-dot')?.classList.add('hidden');
            });

            // Mark yang aktif
            const radio = label.querySelector('input[type="radio"]');
            radio.checked = true;
            label.classList.add('selected-metode');
            label.querySelector('.check-dot')?.classList.remove('hidden');

            if (radio.value === 'qris') {
                label.classList.remove('border-slate-200');
                label.classList.add('border-emerald-500', 'bg-emerald-50');
            } else {
                label.classList.remove('border-slate-200');
                label.classList.add('border-slate-500', 'bg-slate-100');
            }

            updateHargaDisplay();
        });
    });

    // ─── Init state label cash (default checked) ─────────────
    document.getElementById('label-cash').classList.add('border-slate-500', 'bg-slate-100');
    document.getElementById('label-cash').classList.remove('border-slate-200');
    document.getElementById('label-cash').querySelector('.check-dot').classList.remove('hidden');

    // ─── Filter dokter by spesialisasi (AJAX) ────────────────
    document.getElementById('id_spesialisasi').addEventListener('change', function () {
        const spesialisasiId = this.value;
        const dokterSelect   = document.getElementById('id_dokter');
        dokterSelect.innerHTML = '<option value="">Memuat daftar dokter...</option>';

        fetch(`/pasien/get-dokter/${spesialisasiId}`)
            .then(r => r.json())
            .then(data => {
                dokterSelect.innerHTML = '';
                if (!data.length) {
                    dokterSelect.innerHTML = '<option value="">Tidak ada dokter</option>';
                    return;
                }
                data.forEach(d => {
                    const opt       = document.createElement('option');
                    opt.value       = d.id;
                    opt.dataset.price = d.base_price || 75000;
                    opt.textContent = d.nama;
                    dokterSelect.appendChild(opt);
                });
                updateHargaDisplay();
            })
            .catch(() => {
                dokterSelect.innerHTML = '<option value="">Gagal mengambil data</option>';
            });
    });

    // ─── Init harga ──────────────────────────────────────────
    updateHargaDisplay();
</script>
@endpush
@endsection