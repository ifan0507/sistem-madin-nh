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
        Schema::create('nilai_ujian_prakteks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->cascadeOnDelete();
            $table->string('semester');
            $table->string('tahun_ajaran');

            $table->integer('al_quran')->nullable();
            $table->integer('kitab')->nullable();
            $table->integer('muhafadloh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_ujian_prakteks');
    }
};
