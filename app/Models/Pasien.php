<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Model
{
    use SoftDeletes;
    protected $table = 'pasien'; 
    protected $primaryKey = 'id';
    
    // Sangat penting: matikan timestamps agar Laravel tidak error mencari kolom created_at
    public $timestamps = false;

    // Pastikan 'nama' ada di sini agar bisa diakses
    protected $fillable = [
        'id_user', 'gol_darah', 'riwayat_penyakit', 'nama', 
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function user()
    {
        // Pasien memiliki 'id_user' yang merujuk ke 'id' di tabel 'akun_user'
        return $this->belongsTo(\App\Models\AkunUser::class, 'id_user', 'id');
    }
    
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_pasien', 'id');
    }

    public function alergi()
    {
        return $this->hasMany(Alergi::class, 'id_pasien', 'id');
    }

    // ─── Helper ───────────────────────────────────────────────

    public function getGolDarahLabelAttribute(): string
    {
        return $this->gol_darah ?? '-';
    }
}