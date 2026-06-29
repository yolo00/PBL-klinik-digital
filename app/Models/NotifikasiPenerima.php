<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotifikasiPenerima extends Model
{
    protected $table = 'notifikasi_penerima';

    // Tidak pakai timestamps laravel (tidak ada created_at / updated_at di tabel ini)
    public $timestamps = false;

    protected $fillable = [
        'id_notifikasi',
        'id_user',
        'is_seen',
        'seen_at',
    ];

    protected $casts = [
        'is_seen'  => 'boolean',
        'seen_at'  => 'datetime',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function notifikasi(): BelongsTo
    {
        return $this->belongsTo(Notifikasi::class, 'id_notifikasi', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(AkunUser::class, 'id_user', 'id');
    }
}
