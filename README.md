# 🏥 UniHealth — Sistem Klinik Digital Kampus

> Sistem berbasis web untuk administrasi dan pengelolaan layanan kesehatan klinik kampus secara digital.

---

## 📖 Tentang Proyek

**UniHealth** adalah aplikasi web klinik digital yang dirancang untuk membantu proses administrasi dan pengelolaan layanan kesehatan di lingkungan kampus. Sistem ini hadir sebagai solusi atas berbagai kendala pengelolaan data medis secara konvensional, seperti penumpukan dokumen fisik, risiko kehilangan data, serta lambatnya proses pendaftaran dan penjadwalan pasien.

Melalui UniHealth, seluruh data pasien, rekam medis, jadwal pemeriksaan, dan proses administrasi dapat disimpan dan dikelola secara terpusat. Sistem ini dapat diakses secara fleksibel oleh tiga jenis pengguna sesuai hak akses masing-masing: **Admin**, **Dokter**, dan **Pasien**.

---

## ✨ Fitur Utama

### 👤 Pasien
- Registrasi akun dan profil pasien
- Pembuatan janji temu (pilih dokter, tanggal, dan sesi)
- Riwayat jadwal konsultasi
- Riwayat rekam medis dan resep obat
- Riwayat dan status pembayaran

### 🩺 Dokter
- Dashboard jadwal harian
- Manajemen jadwal pribadi dan pengajuan cuti
- Daftar pasien yang terdaftar
- Pengelolaan rekam medis pasien
- Pengaturan jadwal operasional

### 🛠️ Admin
- Dashboard statistik sistem (total pasien, dokter aktif, rekam medis baru)
- Manajemen data dokter (tambah, edit, hapus, lihat detail)
- Manajemen data pasien
- Pengelolaan jadwal konsultasi
- Manajemen pembayaran
- Manajemen rekam medis
- Persetujuan/penolakan pengajuan cuti dokter

---

## 🗂️ Struktur Halaman (Views)

```
views/
├── home.blade.php              # Landing page publik
├── about.blade.php             # Halaman tentang kami
├── login.blade.php             # Halaman masuk
├── register.blade.php          # Registrasi akun pasien
├── contact.blade.php           # Halaman kontak
│
├── admin/
│   ├── dashboard.blade.php
│   ├── dokter-*.blade.php      # CRUD data dokter
│   ├── pasien-*.blade.php      # CRUD data pasien
│   ├── jadwal-sistem.blade.php # Jadwal & cuti dokter
│   ├── pembayaran-*.blade.php  # Manajemen pembayaran
│   └── rekam-medis-*.blade.php # Manajemen rekam medis
│
├── dokter/
│   ├── dashboard-dokter.blade.php
│   ├── jadwal-saya.blade.php
│   ├── pasien-dokter.blade.php
│   ├── rekam-medis-dokter.blade.php
│   ├── edit-rekam-medis.blade.php
│   ├── pengaturan-jadwal.blade.php
│   └── profil-dokter.blade.php
│
└── pasien/
    ├── dashboard.blade.php
    ├── buat-janji.blade.php
    ├── riwayat-jadwal.blade.php
    ├── riwayat-rekam-medis.blade.php
    ├── riwayat-pembayaran.blade.php
    ├── pembayaran.blade.php
    ├── lihat.blade.php
    └── profil.blade.php
```

---

## 🎨 Desain Sistem

- **Font:** Outfit (Google Fonts)
- **Warna Utama:** Emerald (`#059669`) — mencerminkan nuansa kesehatan
- **Border Radius:** Konsisten menggunakan `rounded-[32px]` / `rounded-[40px]` untuk card utama
- **Framework CSS:** Tailwind CSS
- **Animasi:** `fadeInUp` untuk page load, `animate-pulse` untuk indikator status aktif

### Palet Warna Status
| Status | Warna |
|---|---|
| Dikonfirmasi / Aktif | Emerald (`emerald-100/700`) |
| Menunggu / Pending | Amber (`amber-100/700`) |
| Dibatalkan / Ditolak | Rose (`rose-100/700`) |
| Selesai / Lunas | Sky (`sky-100/700`) |

---

## 🛠️ Teknologi

| Layer | Teknologi |
|---|---|
| Backend | Laravel (PHP) |
| Templating | Blade |
| CSS Framework | Tailwind CSS |
| Build Tool | Vite |
| Font | Google Fonts — Outfit |
| Pembayaran | QRIS & Cash |

---

## 📍 Informasi Klinik

| | |
|---|---|
| **Lokasi** | Politeknik Negeri Batam, Jl. Ahmad Yani, Batam Center, Batam Kota, Kepri 29461 |
| **Jam Operasional** | Senin – Jumat: 08.00 – 17.00 WIB |
| **Email** | health67@gmail.com |
| **Telepon** | 0671-2345-6789 |

---

## 👨‍💻 Tim Pengembang

| Nama | Peran |
|---|---|
| **Michael Sando Turnip** | Pengelola Database · Developer Halaman Admin |
| **Aprillia Bunga** | Frontend Developer · Developer Halaman Pasien |
| **Fenni Patrik Simanjuntak** | Developer Halaman Dokter · Desainer Logo Web |

---

## 📄 Lisensi

© 2026 UniHealth System. All rights reserved.  
Dikembangkan sebagai proyek klinik digital kampus — Politeknik Negeri Batam.