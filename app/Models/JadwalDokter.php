<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected $table = 'jadwal_dokter';
    protected $primaryKey = 'id';

    // Tabel jadwal_dokter tidak memiliki timestamps
    public $timestamps = false;

    protected $fillable = [
        'id_dokter', 'hari', 'jam_mulai', 'jam_selesai',
        'override_istirahat_mulai', 'override_istirahat_selesai', 'is_aktif',
    ];

    protected $casts = [
        'jam_mulai'                  => 'integer',
        'jam_selesai'                => 'integer',
        'override_istirahat_mulai'   => 'integer',
        'override_istirahat_selesai' => 'integer',
        'is_aktif'                   => 'boolean',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id');
    }

    // ─── Helper ───────────────────────────────────────────────


    public function getJamMulaiFormatAttribute(): string
    {
        return sprintf('%02d:00', $this->jam_mulai);
    }

    public function getJamSelesaiFormatAttribute(): string
    {
        return sprintf('%02d:00', $this->jam_selesai);
    }
}
