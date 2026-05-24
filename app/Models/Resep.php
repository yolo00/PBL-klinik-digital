<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table = 'resep';
    protected $primaryKey = 'id';          // SQL: PRIMARY KEY (`id`)

    // Tabel resep tidak memiliki timestamps
    public $timestamps = false;

    protected $fillable = [
        'id_rekam', 'obat', 'dosis', 'aturan_pakai',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'id_rekam', 'id');
    }
}
