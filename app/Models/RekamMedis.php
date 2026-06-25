<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekamMedis extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table      = 'rekam_medis';
    protected $primaryKey = 'id';
    public    $timestamps = true;

    /**
     * BUG FIX: hilangkan 'id_pasien' dari fillable karena kolom ini
     * tidak ada di tabel rekam_medis (pasien diambil via relasi jadwal).
     * Tambahkan 'tindakan' dan 'catatan' yang sebelumnya sering hilang.
     */
    protected $fillable = [
        'id_jadwal',
        'keluhan',
        'diagnosa',
        'catatan',
        'created_by',
        'updated_by',
        'is_final',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id');
    }

    public function resep()
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

    /**
     * Relasi ke Pasien melalui Jadwal (hasOneThrough)
     * BUG FIX: urutan parameter hasOneThrough diperbaiki.
     * hasOneThrough(FinalModel, IntermediateModel, fk_on_intermediate, fk_on_final, lk_on_this, lk_on_intermediate)
     */
    public function pasien()
    {
        return $this->hasOneThrough(
            Pasien::class,  // Model tujuan akhir
            Jadwal::class,  // Model perantara
            'id',           // FK di jadwal yang menunjuk ke rekam_medis.id_jadwal? Tidak — ini local key di jadwal
            'id',           // FK di pasien
            'id_jadwal',    // Local key di rekam_medis → cocok dengan jadwal.id
            'id_pasien'     // Local key di jadwal → cocok dengan pasien.id
        );
    }

    /**
     * Relasi ke Dokter melalui Jadwal
     */
    public function dokter()
    {
        return $this->hasOneThrough(
            Dokter::class,
            Jadwal::class,
            'id',
            'id',
            'id_jadwal',
            'id_dokter'
        );
    }

    // ─── Accessor ─────────────────────────────────────────────

    /** Nama pasien via jadwal → digunakan di tabel rekam medis */
    public function getNamaPasienAttribute(): string
    {
        return $this->jadwal?->pasien?->user?->nama ?? '(Tanpa Pasien)';
    }

    /** Nama dokter via jadwal */
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