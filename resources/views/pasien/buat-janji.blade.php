@extends('pasien.layouts.app')
@section('title', 'Buat Janji Temu')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
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
            <label class="block text-lg font-bold text-gray-800"><b>🩺 Pilih Jenis Dokter (Spesialisasi)</b></label>
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
                <option value="">Pilih dokter...</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}"
                            data-price="{{ $dokter->spesialisasi->base_price > 0 ? $dokter->spesialisasi->base_price : 75000 }}">
                        {{ $dokter->user->nama ?? ($dokter->user->name ?? 'Dokter Tanpa Nama') }}
                    </option>
                @endforeach
            </select>
            
            {{-- BIODATA DOKTER --}}
            <div id="biodata-dokter-container" class="hidden mt-4 p-5 bg-emerald-50/50 border border-emerald-100 rounded-2xl">
                <div class="grid grid-cols-[2fr_8fr] gap-6 items-center">
                    <div>
                        <img id="biodata-foto" src="" alt="Foto Dokter" class="w-full aspect-square object-cover rounded-2xl shadow-sm border border-emerald-200">
                    </div>
                    <div class="space-y-2">
                        <h4 id="biodata-nama" class="text-xl font-bold text-slate-800">Nama Dokter</h4>
                        <p id="biodata-spesialisasi" class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">Spesialisasi</p>
                        
                        <div class="grid grid-cols-2 gap-4 mt-3 pt-3 border-t border-emerald-200/50">
                            <div>
                                <span class="block text-xs font-semibold text-slate-400">Jenis Kelamin</span>
                                <span id="biodata-jk" class="text-sm font-medium text-slate-700">-</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-slate-400">No. Telepon</span>
                                <span id="biodata-hp" class="text-sm font-medium text-slate-700">-</span>
                            </div>
                            <div class="col-span-2">
                                <span class="block text-xs font-semibold text-slate-400">Hari Praktik Aktif</span>
                                <span id="biodata-hari" class="text-sm font-medium text-slate-700">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informasi Riwayat Kesehatan Pasien (Sinkronisasi Profil) --}}
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
                <input type="text" name="tanggal" id="tanggal" required placeholder="Pilih dokter terlebih dahulu"
                       class="w-full p-5 bg-white border border-gray-200 rounded-2xl outline-none transition-all duration-200 cursor-pointer hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 disabled:bg-gray-50 disabled:cursor-not-allowed disabled:hover:border-gray-200 disabled:focus:ring-0" disabled>
            </div>
            <div class="space-y-4">
                <label class="block text-lg font-bold text-gray-800">⏰ Pilih Waktu</label>
                <select name="jam" id="jam" class="w-full p-5 bg-white border border-gray-200 rounded-2xl outline-none transition-all duration-200 cursor-pointer hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 disabled:bg-gray-50 disabled:cursor-not-allowed disabled:hover:border-gray-200 disabled:focus:ring-0" required>
                    <option value="">Pilih dokter dan tanggal terlebih dahulu</option>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    let doktersDataMap = {};
    let fpTanggal = null;

    // ─── INIT FLATPICKR ──────────────────────────────────────
    function initFlatpickr(allowedDays = [], disabledDates = [], disabledDays = []) {
        const inputTanggal = document.getElementById('tanggal');
        inputTanggal.disabled = false;
        inputTanggal.placeholder = "Pilih tanggal konsultasi";

        if (fpTanggal) {
            fpTanggal.destroy();
        }
        
        fpTanggal = flatpickr("#tanggal", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d-m-Y",
            minDate: "today",
            maxDate: new Date().fp_incr(21),
            disableMobile: "true",
            disable: [
                function(date) {
                    const day = date.getDay();
                    if (!allowedDays.includes(day)) return true;
                    if (disabledDays.includes(day)) return true;
                    return false;
                },
                ...disabledDates
            ],
            onChange: function(selectedDates, dateStr, instance) {
                fetchJamTersedia();
            }
        });
    }

    // ─── AMBIL JADWAL TERSEDIA (FLATPICKR) ────────────────────
    function fetchJadwalTersedia(dokterId) {
        if (!dokterId) {
            if(fpTanggal) fpTanggal.destroy();
            document.getElementById('tanggal').disabled = true;
            document.getElementById('tanggal').value = '';
            document.getElementById('tanggal').placeholder = "Pilih dokter terlebih dahulu";
            return;
        }

        fetch(`/pasien/get-jadwal-tersedia/${dokterId}`)
            .then(r => r.json())
            .then(res => {
                initFlatpickr(res.allowedDays, res.disabledDates, res.disabledDays);
            })
            .catch(err => console.error("Gagal mengambil jadwal tersedia:", err));
    }


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
                ? 'Anda akan diarahkan ke riwayat jadwal untuk pembayaran QRIS'
                : 'Bayar di klinik saat tiba';
    }

    // ─── Ambil Jam Tersedia via AJAX Berdasarkan Dokter & Tanggal ───
    function fetchJamTersedia() {
        const dokterId = document.getElementById('id_dokter').value;
        const tanggalVal = document.getElementById('tanggal').value;
        const jamSelect = document.getElementById('jam');

        if (!dokterId || !tanggalVal) {
            jamSelect.innerHTML = '<option value="">Pilih dokter dan tanggal terlebih dahulu</option>';
            jamSelect.disabled = true;
            return;
        }

        jamSelect.disabled = false;
        jamSelect.innerHTML = '<option value="">Memuat jam tersedia...</option>';

        fetch(`/pasien/get-jam-dokter?id_dokter=${dokterId}&tanggal=${tanggalVal}`)
        .then(r => r.json())
        .then(res => {
            jamSelect.innerHTML = '';

            if (res.status === 'full') {
                // Semua slot terisi
                jamSelect.innerHTML = '<option value="">Jadwal hari ini sudah penuh</option>';
                jamSelect.disabled = true;

            } else if (res.status === 'success' && res.data.length > 0) {
                // Filter hanya slot yang belum terisi
                const slotTersedia = res.data.filter(j => !j.sudah_terisi);

                if (slotTersedia.length === 0) {
                    // Semua slot ternyata terisi (fallback, seharusnya sudah caught di backend)
                    jamSelect.innerHTML = '<option value="">Jadwal hari ini sudah penuh</option>';
                    jamSelect.disabled = true;
                } else {
                    jamSelect.disabled = false;
                    jamSelect.innerHTML = '<option value="">Pilih jam konsultasi...</option>';
                    slotTersedia.forEach(jamObj => {
                        const opt = document.createElement('option');
                        opt.value = jamObj.value;
                        opt.textContent = jamObj.label;
                        jamSelect.appendChild(opt);
                    });
                }

            } else if (res.status === 'not_available') {
                jamSelect.innerHTML = '<option value="">Dokter tidak praktik di hari ini</option>';
                jamSelect.disabled = true;

            } else {
                jamSelect.innerHTML = '<option value="">Tidak ada slot jam tersedia</option>';
                jamSelect.disabled = true;
            }
        })
        .catch(() => {
            jamSelect.innerHTML = '<option value="">Gagal mengambil data jadwal</option>';
            jamSelect.disabled = true;
        });
    }

    function updateBiodataUI(dokterId) {
        const container = document.getElementById('biodata-dokter-container');
        if (!dokterId || !doktersDataMap[dokterId]) {
            container.classList.add('hidden');
            return;
        }
        
        const d = doktersDataMap[dokterId];
        document.getElementById('biodata-nama').textContent = d.nama;
        document.getElementById('biodata-spesialisasi').textContent = d.spesialisasi;
        document.getElementById('biodata-jk').textContent = d.jenis_kelamin;
        document.getElementById('biodata-hp').textContent = d.no_hp;
        document.getElementById('biodata-hari').textContent = d.hari_aktif;
        
        // Handle photo error fallback
        const img = document.getElementById('biodata-foto');
        img.src = d.foto_profil;
        img.onerror = function() {
            this.src = 'https://placehold.co/150x150/059669/ffffff?text=U';
        };

        container.classList.remove('hidden');
    }

    // ─── Update UI saat dokter berganti ─────────────────────
    document.getElementById('id_dokter').addEventListener('change', function() {
        updateHargaDisplay();
        updateBiodataUI(this.value);
        fetchJadwalTersedia(this.value);
        fetchJamTersedia();
    });

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

    // ─── Load daftar dokter pertama kali untuk map data biodata
    function loadDokterData(spesialisasiId = 'all') {
        fetch(`/pasien/get-dokter/${spesialisasiId}`)
            .then(r => r.json())
            .then(data => {
                const dokterSelect = document.getElementById('id_dokter');
                const currentValue = dokterSelect.value;
                
                dokterSelect.innerHTML = '<option value="">Pilih dokter...</option>';
                doktersDataMap = {};

                if (!data.length) {
                    updateBiodataUI(null);
                    fetchJadwalTersedia(null);
                    fetchJamTersedia();
                    return;
                }
                
                data.forEach(d => {
                    doktersDataMap[d.id] = d;
                    const opt       = document.createElement('option');
                    opt.value       = d.id;
                    opt.dataset.price = d.base_price || 75000;
                    opt.textContent = d.nama;
                    dokterSelect.appendChild(opt);
                });

                // Restore selected value if still valid
                if (currentValue && doktersDataMap[currentValue]) {
                    dokterSelect.value = currentValue;
                    updateBiodataUI(currentValue);
                    fetchJadwalTersedia(currentValue);
                } else {
                    updateBiodataUI(null);
                    fetchJadwalTersedia(null);
                }
                
                updateHargaDisplay();
                fetchJamTersedia();
            })
            .catch(() => {
                document.getElementById('id_dokter').innerHTML = '<option value="">Gagal mengambil data</option>';
            });
    }

    // ─── Filter dokter by spesialisasi (AJAX) ────────────────
    document.getElementById('id_spesialisasi').addEventListener('change', function () {
        loadDokterData(this.value);
    });

    // ─── Init awal data saat halaman dimuat ──────────────────
    loadDokterData('all');
    document.getElementById('jam').disabled = true; // disable jam di awal

    // Tutup flatpickr saat discroll agar popup tidak melayang terpisah
    window.addEventListener('scroll', function() {
        if (fpTanggal && fpTanggal.isOpen) {
            fpTanggal.close();
        }
    }, { passive: true });
</script>
@endpush
@endsection