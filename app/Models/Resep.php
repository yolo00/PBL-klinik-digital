<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table = 'resep';
    protected $primaryKey = 'id_resep';

    // Hanya punya created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'id_rekam', 'nama_obat', 'dosis', 'aturan_pakai', 'jumlah',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'id_rekam', 'id_rekam');
    }
}
