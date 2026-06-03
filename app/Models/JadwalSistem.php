<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalSistem extends Model
{
    protected $table = 'jadwal_sistem';

    protected $fillable = [
        'hari',
        'jam_buka',
        'jam_tutup',
        'jam_istirahat_mulai',
        'jam_istirahat_selesai',
        'is_libur',
        'keterangan',
        'tgl_khusus',
    ];

    protected $casts = [
        'tgl_khusus'           => 'date',
        'is_libur'             => 'boolean',
        'jam_buka'             => 'integer',
        'jam_tutup'            => 'integer',
        'jam_istirahat_mulai'  => 'integer',
        'jam_istirahat_selesai'=> 'integer',
    ];

    public static function urutanHari(): array
    {
        return [
            'Senin'  => 1,
            'Selasa' => 2,
            'Rabu'   => 3,
            'Kamis'  => 4,
            'Jumat'  => 5,
            'Sabtu'  => 6,
            'Minggu' => 7,
        ];
    }


    /** Jadwal harian reguler (Senin–Minggu) */
    public function scopeHarian($query)
    {
        return $query->whereNotNull('hari')->whereNull('tgl_khusus');
    }

    /** Tanggal khusus (libur / jam berbeda) */
    public function scopeTanggalKhusus($query)
    {
        return $query->whereNotNull('tgl_khusus');
    }

    // ── Accessors ──────────────────────────────────────────────

    /** Format jam 2 digit */
    public function formatJam(?int $jam): string
    {
        if ($jam === null) return '-';
        return sprintf('%02d:00', $jam);
    }

    public function getJamBukaFormatAttribute(): string
    {
        return $this->formatJam($this->jam_buka);
    }

    public function getJamTutupFormatAttribute(): string
    {
        return $this->formatJam($this->jam_tutup);
    }

    /** Tampilkan istirahat*/
    public function getJamIstirahatDisplayAttribute(): string
    {
        if ($this->jam_istirahat_mulai === null) return '-';
        $mulai = $this->formatJam($this->jam_istirahat_mulai);
        if ($this->jam_istirahat_selesai === null) return $mulai;
        return $mulai . ' – ' . $this->formatJam($this->jam_istirahat_selesai);
    }
}