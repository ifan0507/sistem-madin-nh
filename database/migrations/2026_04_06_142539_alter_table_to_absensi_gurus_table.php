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
        Schema::table('absensi_gurus', function (Blueprint $table) {
            $table->date('tanggal')->after('mapel_kelas_id');
            $table->string('tahun_ajaran', 10)->after('status')->nullable()->index();
            $table->enum('semester', ['Ganjil', 'Genap'])->after('tahun_ajaran')->nullable()->index();
            $table->integer('pertemuan_ke')->after('semester');
            $table->integer('minggu_ke')->after('pertemuan_ke');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi_gurus', function (Blueprint $table) {
            $table->dropColumn(['tanggal', 'tahun_ajaran', 'semester', 'pertemuan_ke', 'minggu_ke']);
        });
    }
};
