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
        Schema::table('nilai_ujians', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->after('mapel_id')->constrained('kelas')->onDelete('cascade');
            $table->string('tahun_ajaran', 20)->nullable()->after('kelas_id');
            $table->enum('semester', ['Ganjil', 'Genap'])->nullable()->after('tahun_ajaran');
            $table->foreignId('guru_id')->nullable()->after('semester')->constrained('users')->nullOnDelete();
            $table->unique(['santri_id', 'mapel_id', 'semester', 'tahun_ajaran'], 'unik_nilai_mapel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_ujians', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['guru_id']);
            $table->dropUnique('unik_nilai_mapel');

            $table->dropColumn(['kelas_id', 'tahun_ajaran', 'semester', 'guru_id']);
        });
    }
};
