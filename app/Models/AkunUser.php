<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AkunUser extends Authenticatable
{
    protected $table = 'akun_user';
    protected $primaryKey = 'id_user';

    const UPDATED_AT = null;

    protected $fillable = [
        'email', 'password', 'nama', 'no_hp',
        'jenis_kelamin', 'tgl_lahir', 'foto_profil', 'role',
    ];

    protected $hidden = ['password'];


    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'id_user', 'id_user');
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id_user', 'id_user');
    }

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
