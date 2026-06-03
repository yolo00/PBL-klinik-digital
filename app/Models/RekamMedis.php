<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    // Nama tabel aslimu di database
    protected $table = 'rekam_medis';

    // Kolom yang boleh diisi massal saat disimpan
    protected $fillable = [
        'id_pasien', // Menggunakan id_pasien sesuai struktur database kelompokmu
        'keluhan',
        'diagnosa',
        'tindakan',
        'resep_obat'
    ];

    // 🌟 KUNCI UTAMA: Daftarkan relasi ke tabel Pasien
    public function pasien()
{
    // Pastikan 'id_pasien' sesuai dengan nama kolom foreign key di tabel rekam_medis kamu
    return $this->belongsTo(Pasien::class, 'id_pasien');
}
}