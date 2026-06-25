<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Jika kolom sudah ada (mis. migrasi pernah dijalankan), abaikan agar tidak gagal.
            if (!Schema::hasColumn('rekam_medis', 'is_final')) {
                $table->boolean('is_final')->default(false)->after('id_jadwal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->dropColumn('is_final');
        });
    }
};

