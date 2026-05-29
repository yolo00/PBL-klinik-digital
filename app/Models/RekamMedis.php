<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_jadwal', 'keluhan', 'diagnosa', 'catatan', 'created_by', 'updated_by',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id');
    }

    public function reseps()
    {
        return $this->hasMany(Resep::class, 'id_rekam', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(AkunUser::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(AkunUser::class, 'updated_by', 'id');
    }

    // ─── Accessor ─────────────────────────────────────────────

    /** Shortcut ke nama pasien via jadwal */
    public function getNamaPasienAttribute(): string
    {
        return $this->jadwal?->pasien?->user?->nama ?? '(Tanpa Pasien)';
    }

    /** Shortcut ke nama dokter via jadwal */
    public function getNamaDokterAttribute(): string
    {
        return $this->jadwal?->dokter?->user?->nama ?? '—';
    }

    /** Diagnosa dipotong untuk tampilan tabel */
    public function getDiagnosaSingkatAttribute(): string
    {
        return \Illuminate\Support\Str::limit($this->diagnosa ?? '—', 60);
    }
}