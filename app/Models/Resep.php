<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resep extends Model
{
    use SoftDeletes;
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
