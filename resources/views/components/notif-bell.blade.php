{{--
    Component: components/notif-bell.blade.php
    Dipakai di header dokter (layouts/dokter.blade.php) dan admin (layouts/app.blade.php)

    Props (tidak ada — langsung fetch dari /notifikasi lewat JS)
--}}

<div class="relative" id="notif-wrapper">

    {{-- ── Bell Button ── --}}
    <button
        id="notif-bell-btn"
        onclick="toggleNotifDropdown()"
        class="relative w-9 h-9 rounded-full bg-white/15 flex items-center justify-center text-white hover:bg-white/25 transition"
        title="Notifikasi"
    >
        <i class="fa-solid fa-bell text-sm"></i>

        {{-- Badge count (disembunyikan kalau 0) --}}
        <span
            id="notif-badge"
            class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-current hidden"
        ></span>
    </button>

    {{-- ── Dropdown Panel ── --}}
    <div
        id="notif-dropdown"
        class="hidden absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 z-[100] overflow-hidden"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
            <span class="text-sm font-bold text-slate-800">Notifikasi</span>
            <button
                onclick="markAllSeen()"
                class="text-xs text-blue-600 hover:underline font-medium"
            >Tandai semua dibaca</button>
        </div>

        {{-- List --}}
        <div id="notif-list" class="max-h-80 overflow-y-auto divide-y divide-slate-50">
            <div class="flex items-center justify-center py-10 text-slate-400 text-sm" id="notif-loading">
                <i class="fa-solid fa-spinner fa-spin mr-2"></i> Memuat...
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-4 py-2.5 border-t border-slate-100 text-center">
            <span class="text-xs text-slate-400">Menampilkan 20 notifikasi terbaru</span>
        </div>
    </div>
</div>

{{-- ── Script (letakkan satu kali di halaman, sudah di-guard) ── --}}
<script>
(function () {
    // Guard agar script tidak dijalankan dua kali
    if (window._notifScriptLoaded) return;
    window._notifScriptLoaded = true;

    const BELL_BTN   = () => document.getElementById('notif-bell-btn');
    const BADGE      = () => document.getElementById('notif-badge');
    const DROPDOWN   = () => document.getElementById('notif-dropdown');
    const LIST       = () => document.getElementById('notif-list');
    const LOADING    = () => document.getElementById('notif-loading');
    const CSRF       = document.querySelector('meta[name="csrf-token"]')?.content || '';

    let isOpen     = false;
    let cacheItems = null;     // cache hasil fetch agar tidak double-hit

    // ── Toggle dropdown ────────────────────────────────────────
    window.toggleNotifDropdown = function () {
        isOpen = !isOpen;
        DROPDOWN().classList.toggle('hidden', !isOpen);

        if (isOpen) {
            fetchNotif();
        }
    };

    // Tutup dropdown kalau klik di luar
    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('notif-wrapper');
        if (wrapper && !wrapper.contains(e.target) && isOpen) {
            isOpen = false;
            DROPDOWN()?.classList.add('hidden');
        }
    });

    // ── Fetch daftar notifikasi ────────────────────────────────
    async function fetchNotif() {
        LIST().innerHTML = '<div class="flex items-center justify-center py-10 text-slate-400 text-sm"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Memuat...</div>';

        try {
            const res  = await fetch('/notifikasi', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            cacheItems = data.items;
            renderList(data.items);
            updateBadge(data.unseen_count);
        } catch (err) {
            LIST().innerHTML = '<div class="py-6 text-center text-slate-400 text-sm">Gagal memuat notifikasi.</div>';
        }
    }

    // ── Render item ke DOM ─────────────────────────────────────
    function renderList(items) {
        if (!items || items.length === 0) {
            LIST().innerHTML = '<div class="py-10 text-center text-slate-400 text-sm"><i class="fa-regular fa-bell-slash text-2xl mb-2 block"></i>Belum ada notifikasi</div>';
            return;
        }

        LIST().innerHTML = items.map(item => `
            <div class="flex gap-3 px-4 py-3 hover:bg-slate-50 transition cursor-default ${item.is_seen ? 'opacity-60' : ''}">
                <div class="shrink-0 mt-0.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs ${notifIconClass(item)}">
                        <i class="${notifIcon(item)}"></i>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-slate-800 leading-snug flex items-center gap-1.5">
                        ${escHtml(item.type)}
                        ${item.is_urgent ? '<span class="text-[9px] font-bold bg-red-100 text-red-600 px-1.5 py-0.5 rounded-full">URGENT</span>' : ''}
                        ${!item.is_seen ? '<span class="w-2 h-2 rounded-full bg-blue-500 inline-block shrink-0"></span>' : ''}
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5 leading-snug">${escHtml(item.message)}</p>
                    <p class="text-[10px] text-slate-400 mt-1">${escHtml(item.created_at)}</p>
                </div>
            </div>
        `).join('');
    }

    // ── Ikon berdasarkan ref_tabel ─────────────────────────────
    function notifIcon(item) {
        const map = {
            jadwal:      'fa-solid fa-calendar-day',
            cuti_dokter: 'fa-solid fa-calendar-xmark',
            rekam_medis: 'fa-solid fa-notes-medical',
            pembayaran:  'fa-solid fa-money-bill-wave',
        };
        return map[item.ref_tabel] ?? 'fa-solid fa-bell';
    }
    function notifIconClass(item) {
        const map = {
            jadwal:      'bg-blue-50 text-blue-500',
            cuti_dokter: 'bg-amber-50 text-amber-500',
            rekam_medis: 'bg-emerald-50 text-emerald-500',
            pembayaran:  'bg-violet-50 text-violet-500',
        };
        return map[item.ref_tabel] ?? 'bg-slate-100 text-slate-400';
    }

    // ── Tandai semua dibaca ────────────────────────────────────
    window.markAllSeen = async function () {
        try {
            await fetch('/notifikasi/mark-all-seen', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN'     : CSRF,
                    'X-Requested-With' : 'XMLHttpRequest',
                    'Content-Type'     : 'application/json',
                },
            });
            updateBadge(0);
            fetchNotif();   // refresh list
        } catch (_) {}
    };

    // ── Update badge ───────────────────────────────────────────
    function updateBadge(count) {
        const badge = BADGE();
        if (!badge) return;
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    // ── Polling ringan setiap 60 detik (badge saja) ───────────
    async function pollBadge() {
        try {
            const res  = await fetch('/notifikasi/unseen-badge', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            updateBadge(data.unseen_count);

            // Sidebar dot: "Jadwal Konsultasi" (Dokter)
            const dotJadwal = document.getElementById('sidebar-jadwal-dot');
            if (dotJadwal) dotJadwal.classList.toggle('hidden', !data.has_jadwal_baru);

            // Sidebar dot: "Pengaturan Jadwal" (Dokter)
            const dotPengaturan = document.getElementById('sidebar-pengaturan-dot');
            if (dotPengaturan) dotPengaturan.classList.toggle('hidden', !data.has_pengaturan_dot);

            // Sidebar dot: "Riwayat Jadwal" (Pasien)
            const dotJadwalPasien = document.getElementById('sidebar-jadwal-pasien-dot');
            if (dotJadwalPasien) dotJadwalPasien.classList.toggle('hidden', !data.has_jadwal_pasien_dot);

            // Sidebar dot: "Rekam Medis" (Pasien)
            const dotRekamMedis = document.getElementById('sidebar-rekam-medis-dot');
            if (dotRekamMedis) dotRekamMedis.classList.toggle('hidden', !data.has_rekam_medis_dot);
            
        } catch (_) {}
    }

    // Pertama kali langsung poll
    pollBadge();
    setInterval(pollBadge, 60_000);

    // Util escape
    function escHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
})();
</script>
