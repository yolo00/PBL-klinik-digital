<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spesialisasi extends Model
{
    use SoftDeletes;
    protected $table = 'spesialisasi';
    protected $primaryKey = 'id';

    // Tabel spesialisasi tidak memiliki timestamps
    public $timestamps = false;

    protected $fillable = ['nama', 'base_price'];
    // ─── Relasi ───────────────────────────────────────────────

    public function dokters()
    {
        return $this->hasMany(Dokter::class, 'id_spesialisasi', 'id');
    }
}
