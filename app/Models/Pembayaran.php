<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    // Hanya punya created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'id_jadwal', 'jumlah', 'metode', 'status', 'nomor_struk',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    // ─── Helper ───────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'lunas'   => 'Lunas',
            'batal'   => 'Batal',
            default   => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'text-amber-600',
            'lunas'   => 'text-emerald-600',
            'batal'   => 'text-rose-600',
            default   => 'text-slate-600',
        };
    }

    public function getJumlahFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }
}
