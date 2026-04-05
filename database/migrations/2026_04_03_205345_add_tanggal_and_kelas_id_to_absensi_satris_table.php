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
        Schema::table('absensi_santris', function (Blueprint $table) {
            $table->foreignId('kelas_id')->after('santri_id')->nullable()->constrained('kelas')->onDelete('cascade');
            $table->date('tanggal')->after('kelas_id')->nullable();
            $table->unique(['santri_id', 'kelas_id', 'tanggal'], 'absen_unik_santri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi_santris', function (Blueprint $table) {
            $table->dropUnique('absen_unik_santri');
            $table->dropForeign(['kelas_id']);
            $table->dropColumn(['kelas_id', 'tanggal']);
        });
    }
};
