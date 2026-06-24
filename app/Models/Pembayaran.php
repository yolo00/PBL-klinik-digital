<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use SoftDeletes;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id';          // SQL: PRIMARY KEY (`id`)

    protected $fillable = [
        'id_jadwal', 'jumlah', 'metode', 'status', 'nomor_struk', 'pesan',
        'xendit_external_id', 'xendit_qr_id', 'qr_string', 'payment_expired_at'
    ];

    protected $casts = [
        'payment_expired_at' => 'datetime',
        'jumlah' => 'decimal:2',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id');
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

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
            'lunas'   => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
            'batal'   => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
            default   => 'bg-slate-50 text-slate-700 ring-1 ring-slate-200',
        };
    }

    public function getJumlahFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    public function getMetodeLabelAttribute(): string
    {
        return match ($this->metode) {
            'cash'     => 'Cash',
            'qris'     => 'QRIS',
            'transfer' => 'Transfer Bank',
            default    => strtoupper($this->metode),
        };
    }
}

