<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiDokter extends Model
{
    protected $table = 'cuti_dokter';
    protected $primaryKey = 'id_cuti';

    // Hanya punya created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'id_dokter', 'status', 'alasan', 'dari_tanggal', 'sampai_tanggal',
    ];

    protected $casts = [
        'dari_tanggal'   => 'date',
        'sampai_tanggal' => 'date',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    // ─── Helper ───────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Pending',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'text-amber-600',
            'disetujui' => 'text-emerald-600',
            'ditolak'   => 'text-rose-600',
            default     => 'text-slate-600',
        };
    }
}
