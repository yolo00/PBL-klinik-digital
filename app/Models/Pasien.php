<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';

    // Tabel pasien tidak memiliki timestamps
    public $timestamps = false;

    protected $fillable = ['id_user', 'nimnik'];

    // ─── Relasi ───────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(AkunUser::class, 'id_user', 'id_user');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_pasien', 'id_pasien');
    }
}
