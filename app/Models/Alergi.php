<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alergi extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'alergi';
    
    // Primary Key tidak perlu didefinisikan jika namanya 'id'
    // karena Laravel otomatis mendeteksinya.

    // Tabel alergi tidak memiliki timestamps (created_at/updated_at)
    public $timestamps = false;

    protected $fillable = [
        'id_pasien', 
        'nama_alergi'
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }
}