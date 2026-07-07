# TODO - Design System (Dokter sebagai acuan)

## Phase 0 — Setup
- [ ] Perjelas ruang lingkup: hanya UI/UX + responsive, tanpa ubah route/controller/database.

## Phase 1 — Review & Tokens
- [x] Kumpulkan kelas style dari `resources/views/dokter/layouts/dokter.blade.php` (card, table, badge, buttons, form, empty state).
- [ ] Tentukan set “Design Tokens” (warna, radius, shadow, typography, spacing).

## Phase 2 — Buat UI Layer (Reusable)
- [ ] Tambahkan CSS reusable untuk: `.data-table`, badge status, scrollbar, dan komponen visual dasar ke file CSS global.
- [x] Buat Blade components: `components/ui/*` (card, button, badge, input, textarea, table wrapper, empty state, alert, pagination).

## Phase 3 — Refactor Dokter Layout ke Design System
- [ ] Ubah `resources/views/dokter/layouts/dokter.blade.php` agar style inline di-minimize (dialihkan ke CSS/komponen) tanpa mengubah markup yang bergantung logic.

## Phase 4 — Terapkan ke Admin & Pasien
- [x] Mulai refactor `resources/views/admin/dashboard.blade.php` memakai komponen UI baru.
- [ ] Lanjut ubah `resources/views/admin/**/*.blade.php` dan `resources/views/pasien/**/*.blade.php` untuk memakai komponen UI baru.

## Phase 5 — Landing Page
- [ ] Refactor `resources/views/home.blade.php`, `about.blade.php`, dan landing lainnya agar konsisten dengan design system.

## Phase 6 — Responsive
- [ ] Implementasi sidebar drawer/hamburger pada layout internal (admin/pasien) mengikuti gaya Dokter.
- [ ] Pastikan tabel gunakan `overflow-x-auto`, grid mengikuti breakpoint target.

## Phase 7 — UX polish
- [ ] Samakan empty state, alert (session success/error) menggunakan komponen `ui/alert`.
- [ ] Konsistensi icon dan spacing antar halaman.

