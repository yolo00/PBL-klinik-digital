<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AkunUser extends Authenticatable
{
    protected $table = 'akun_user';
    protected $primaryKey = 'id_user';

    // akun_user hanya punya created_at (tidak ada updated_at)
    const UPDATED_AT = null;

    protected $fillable = [
        'email', 'password', 'nama', 'no_hp',
        'jenis_kelamin', 'tgl_lahir', 'foto_profil', 'role',
    ];

    protected $hidden = ['password'];

    // ─── Relasi ───────────────────────────────────────────────

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'id_user', 'id_user');
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id_user', 'id_user');
    }

    // ─── Helper ───────────────────────────────────────────────

    /** Kembalikan "Dr. [nama pertama]" */
    public function getDrNameAttribute(): string
    {
        $firstName = explode(' ', $this->nama)[0];
        return 'Dr. ' . $firstName;
    }

    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
