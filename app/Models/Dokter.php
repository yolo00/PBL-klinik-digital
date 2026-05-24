<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $primaryKey = 'id';          // SQL: PRIMARY KEY (`id`)

    // Tabel dokter tidak memiliki timestamps
    public $timestamps = false;

    protected $fillable = [
        'id_user', 'id_spesialisasi', 'pendidikan', 'dokumen_sip', 'tanda_tangan',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(AkunUser::class, 'id_user', 'id');
    }

    public function spesialisasi()
    {
        return $this->belongsTo(Spesialisasi::class, 'id_spesialisasi', 'id');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_dokter', 'id');
    }

    public function jadwalDokters()
    {
        return $this->hasMany(JadwalDokter::class, 'id_dokter', 'id');
    }

    public function cutiDokters()
    {
        return $this->hasMany(CutiDokter::class, 'id_dokter', 'id');
    }

    // ─── Helper ───────────────────────────────────────────────

    /** Kembalikan "Dr. [nama pertama]" dari relasi user */
    public function getDrNameAttribute(): string
    {
        if (!$this->relationLoaded('user') || !$this->user) {
            return 'Dr. -';
        }
        $firstName = explode(' ', $this->user->nama)[0];
        return 'Dr. ' . $firstName;
    }
}
