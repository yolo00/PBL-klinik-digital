<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    // Tabel ini tidak pakai updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'type',
        'message',
        'ref_tabel',
        'ref_id',
        'is_urgent',
        'created_by',
    ];

    protected $casts = [
        'is_urgent'  => 'boolean',
        'created_at' => 'datetime',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function penerimas(): HasMany
    {
        return $this->hasMany(NotifikasiPenerima::class, 'id_notifikasi', 'id');
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(AkunUser::class, 'created_by', 'id');
    }

    // ─── Helper statis untuk membuat notif sekaligus penerima ─

    /**
     * Buat notifikasi + distribusikan ke banyak penerima.
     *
     * @param array       $data        Kolom-kolom notifikasi (type, message, ref_tabel, ref_id, is_urgent, created_by)
     * @param array|int   $penerimIds  id_user atau array id_user yang menerima
     */
    public static function kirim(array $data, array|int $penerimIds): self
    {
        $notif = self::create($data);

        $ids = is_array($penerimIds) ? $penerimIds : [$penerimIds];

        // Deduplikasi: hindari insert ganda untuk id yang sama
        $ids = array_unique(array_filter($ids));

        $rows = array_map(fn($id) => [
            'id_notifikasi' => $notif->id,
            'id_user'       => $id,
            'is_seen'       => 0,
            'seen_at'       => null,
        ], $ids);

        NotifikasiPenerima::insert($rows);

        return $notif;
    }
}
