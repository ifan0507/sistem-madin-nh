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
        Schema::create('rapors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('tahun_ajaran', 20);
            $table->enum('semester', ['Ganjil', 'Genap']);

            $table->integer('absen_sakit')->default(0);
            $table->integer('absen_izin')->default(0);
            $table->integer('absen_alfa')->default(0);

            $table->char('nilai_kerapian', 2)->nullable();
            $table->char('nilai_kerajinan', 2)->nullable();
            $table->char('nilai_ketertiban', 2)->nullable();

            $table->text('catatan')->nullable();
            $table->boolean('is_naik_kelas')->nullable();

            $table->integer('peringkat_kelas')->nullable();

            $table->unique(['santri_id', 'kelas_id', 'semester', 'tahun_ajaran'], 'unik_rapor_santri');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapors');
    }
};
