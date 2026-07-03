@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    const BASE_URL = '{{ url("/") }}';
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const FETCH_OPTIONS = {
        credentials: 'same-origin',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json',
        }
    };

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

        fetch(`${BASE_URL}/pasien/get-jadwal-tersedia/${dokterId}`, FETCH_OPTIONS)
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

        fetch(`${BASE_URL}/pasien/get-jam-dokter?id_dokter=${dokterId}&tanggal=${tanggalVal}`, FETCH_OPTIONS)
        .then(r => r.json())
        .then(res => {
            jamSelect.innerHTML = '';

            if (res.status === 'full') {
                // Semua slot terisi
                jamSelect.innerHTML = '<option value="">Jadwal hari ini sudah penuh</option>';
                jamSelect.disabled = true;

            }  else if (res.status === 'success' && res.data.length > 0) {
                // Cek apakah tanggal yang dipilih adalah hari ini
                const today = new Date();
                const todayStr = today.getFullYear() + '-'
                    + String(today.getMonth() + 1).padStart(2, '0') + '-'
                    + String(today.getDate()).padStart(2, '0');
                const isToday = (tanggalVal === todayStr);
                const jamSekarang = today.getHours(); // integer, misal jam 14 = 14

                // Filter: belum terisi DAN (bukan hari ini ATAU jamnya masih akan datang)
                const slotTersedia = res.data.filter(j => {
                    if (j.sudah_terisi) return false;
                    if (isToday && j.value <= jamSekarang) return false;
                    return true;
                });

                if (slotTersedia.length === 0) {
                    // Tentukan pesan yang tepat: sudah tutup atau memang penuh
                    const adaSlotBelumLewat = res.data.some(j => !isToday || j.value > jamSekarang);
                    if (isToday && !adaSlotBelumLewat) {
                        jamSelect.innerHTML = '<option value="">Klinik sudah tutup untuk hari ini</option>';
                    } else {
                        jamSelect.innerHTML = '<option value="">Jadwal hari ini sudah penuh</option>';
                    }
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
        fetch(`${BASE_URL}/pasien/get-dokter/${spesialisasiId}`, FETCH_OPTIONS)
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
