<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_user', 'gol_darah', 'riwayat_penyakit',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(AkunUser::class, 'id_user', 'id');
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
