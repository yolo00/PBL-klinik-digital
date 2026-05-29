Isi database baru.

tabel akun_user(id_user | email | password(tolon encrypt) | nama | no_hp | jenis_kelamin | tgl_lahir | foto_profil | role | created_at(auto fill) )

1 | acbdfehhs1@gmail.com | 789789 | NULL | NULL | NULL | NULL | NULL | A |
2 | feynsiber27@gmail.com| 456456 | Fenni Patrik Simanjuntak | 087767351842 | P | 17 Agustus 1945 | NULL | D |
3 | bubungchii26@gmail.com| 123123 | Aprillia Bunga | 089671168857 | P | 15 Juni 2007 | NULL | P |
4 | sayangsisti24@gmail.com | 333222 | Siti Halimah | 023243253423 | P | 4 Juli 2000 | NULL | D |
5 | aniotono34@gmail.com | 111222 | Budi Santoso | 081234567890 | L | 20 Maret 1985 | NULL | P |

tabel dokter (id_dokter | id_user | spesialis)

1 | 2 | dokter umum |
2 | 4 | dokter umum |

tabel pasien (id_pasien | id_user | nimnik)

1 | 3 | 19120030 |
2 | 5 | 19120030 |

tabel jadwal (id_jadwal | id_dokter | id_pasien | tanggal | jam | status)

1 | 1 | 2 | 2026-04-08 | 09:00 | dibatalkan
2 | 2 | 2 | 2026-04-10 | 10:00 | selesai 
3 | 1 | 1 | 2026-04-10 | 09:00 | selesai 
4 | 1 | 1 | 2026-04-12 | 09:00 | mendatang

tabel pembayaran (id_pembayaran | id_jadwal | metode | jumlah (selalu 50.000) | status | nomor_struk )

1 | 1 | 50000 | batal | qris | NULL
2 | 2 | 50000 | lunas | qris | 0020102040ID.w.bpk.www.593502
3 | 3 | 50000 | lunas | cash | 0020102040ID.w.bpk.www.535205
4 | 4 | 50000 | pending | cash | NULL

tabel rekam_medis (id_rekam_medis | id_jadwal | diagnosa | catatan | keluhan)

1 | 2 | Gejala awal influenza. | Istirahat total selama 2 hari. | Pasien merasa hangat dan meriang sejak 2 hari yang lalu, disertai batuk ringan. |
2 | 3 | Migrain akut. | - | Pasien merasa pusing berdenyut di bagian belakang kepala dan sensitif terhadap cahaya. |

tabel resep (id_resep | id_rekam_medis | obat | dosis | aturan_pakai )

1 | 1 | Paracetamol | 500mg | 3 kali sehari |
2 | 2 | Amoxicillin | 500mg | 3 kali sehari |

