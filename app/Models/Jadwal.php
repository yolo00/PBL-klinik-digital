<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';

    const UPDATED_AT = null;

    protected $fillable = [
        'id_dokter', 'id_pasien', 'tanggal', 'jam', 'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    //Relasi

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'id_jadwal', 'id_jadwal');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_jadwal', 'id_jadwal');
    }

    // ─── Helper ───────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu'    => 'Menunggu',
            'dikonfirmasi'=> 'Dikonfirmasi',
            'selesai'     => 'Selesai',
            'dibatalkan'  => 'Dibatalkan',
            default       => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'menunggu'    => 'text-amber-600',
            'dikonfirmasi'=> 'text-blue-600',
            'selesai'     => 'text-emerald-600',
            'dibatalkan'  => 'text-rose-600',
            default       => 'text-slate-600',
        };
    }
}
