<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AkunUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'akun_user';
    protected $primaryKey = 'id';

    const UPDATED_AT = null;

    protected $fillable = [
        'email', 'password', 'nama', 'no_hp',
        'jenis_kelamin', 'tgl_lahir', 'foto_profil', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'id_user', 'id');
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id_user', 'id');
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

    // Fungsi pintar menerjemahkan kode role A, D, P menjadi nama route dashboard
    public function getHalamanBerandaAttribute(): string
    {
        return match ($this->role) {
            'A' => 'admin.dashboard',
            'D' => 'dokter.dashboard',
            default => 'pasien.dashboard',
        };
    }
}