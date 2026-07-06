# TODO - Pembaruan Fitur Jadwal Dokter

## Rencana Implementasi
1. Tambah helper/formatter tanggal Indonesia untuk nama bulan.
2. Perbarui seluruh tampilan tanggal “Jadwal Dokter” agar bulan tampil bahasa Indonesia (konsisten via formatter).
3. Tambah aksi “Konfirmasi” pada halaman daftar jadwal.
   - Tombol hanya tampil/aktif jika tanggal jadwal = hari ini.
   - Update status jadwal: `menunggu` -> `konfirmasi`.
4. Tambah endpoint/route POST untuk aksi konfirmasi.
5. Sinkronkan UI badge/status label sesuai status baru `konfirmasi`.
6. Bersihkan kolom “Nama Pasien” pada tabel:
   - Hapus avatar/foto profil.
7. Opsional tapi disarankan: bersihkan avatar pada tabel “Jadwal Pemeriksaan Hari Ini” di dashboard.

## Status
- [ ] Plan disetujui dan implementasi dimulai
- [ ] Langkah 1-2 (lokalisasi bulan)
- [x] Langkah 3-5 (aksi Konfirmasi) (status + route + tombol)
- [x] Langkah 3-5 (aksi Konfirmasi) (UI & formatter mulai dikerjakan)
- [ ] Langkah 6-7 (hapus avatar di tabel)
- [x] Langkah 4-5 (route/controller + badge status untuk konfirmasi)

