<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Jadwal extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal';

    protected $fillable = [
        'id_dokter', 'id_pasien', 'tanggal', 'jam', 'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam'     => 'integer',
    ];

    // Otomatis append atribut ini saat model di-convert ke array/JSON
    protected $appends = [
        'jam_format', 
        'status_label', 
        'status_color', 
        'status_badge'
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id');
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }

    public function rekamMedis(): HasOne
    {
        return $this->hasOne(RekamMedis::class, 'id_jadwal', 'id');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_jadwal', 'id');
    }

    // ─── Accessor ─────────────────────────────────────────────

    public function getJamFormatAttribute(): string
    {
        return sprintf('%02d:00', $this->jam);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu'     => 'Menunggu',
            'dikonfirmasi' => 'Dikonfirmasi',
            'selesai'      => 'Selesai',
            'dibatalkan'   => 'Dibatalkan',
            default        => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'menunggu'     => 'text-amber-600',
            'dikonfirmasi' => 'text-blue-600',
            'selesai'      => 'text-emerald-600',
            'dibatalkan'   => 'text-rose-600',
            default        => 'text-slate-600',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu'     => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
            'dikonfirmasi' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
            'selesai'      => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
            'dibatalkan'   => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
            default        => 'bg-slate-50 text-slate-700 ring-1 ring-slate-200',
        };
    }
}