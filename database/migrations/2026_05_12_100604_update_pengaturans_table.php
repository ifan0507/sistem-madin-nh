<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.  
     */
    public function up(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->date('tgl_awal_semester')->nullable()->after('semester');
            
            $table->date('tgl_mulai_kumpul_soal')->nullable()->after('tgl_awal_semester');
            $table->date('tgl_akhir_kumpul_soal')->nullable()->after('tgl_mulai_kumpul_soal');
            
            $table->date('tgl_mulai_kumpul_nilai')->nullable()->after('tgl_akhir_kumpul_soal');
            $table->date('tgl_akhir_kumpul_nilai')->nullable()->after('tgl_mulai_kumpul_nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->dropColumn([
                'tgl_awal_semester',
                'tgl_mulai_kumpul_soal',
                'tgl_akhir_kumpul_soal',
                'tgl_mulai_kumpul_nilai',
                'tgl_akhir_kumpul_nilai'
            ]);
        });
    }
};
