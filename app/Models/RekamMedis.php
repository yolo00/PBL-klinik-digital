<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $primaryKey = 'id_rekam';

    // Hanya punya created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'id_jadwal', 'diagnosa', 'catatan', 'keluhan',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function reseps()
    {
        return $this->hasMany(Resep::class, 'id_rekam', 'id_rekam');
    }
}
