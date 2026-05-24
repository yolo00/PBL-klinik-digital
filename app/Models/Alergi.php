<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergi extends Model
{
    protected $table = 'alergi';
    protected $primaryKey = 'id';

    // Tabel alergi tidak memiliki timestamps
    public $timestamps = false;

    protected $fillable = ['id_pasien', 'nama_alergi'];

    // ─── Relasi ───────────────────────────────────────────────

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }
}
