<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';

    // Tabel dokter tidak memiliki timestamps
    public $timestamps = false;

    protected $fillable = ['id_user', 'spesialis'];

    // ─── Relasi ───────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(AkunUser::class, 'id_user', 'id_user');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_dokter', 'id_dokter');
    }

    public function cutiDokters()
    {
        return $this->hasMany(CutiDokter::class, 'id_dokter', 'id_dokter');
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
