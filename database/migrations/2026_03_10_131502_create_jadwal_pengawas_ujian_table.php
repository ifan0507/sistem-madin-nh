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
        Schema::create('jadwal_pengawas_ujians', function (Blueprint $table) {
            $table->id();
            $table->integer('hari_ke');
            $table->date('tanggal_ujian')->nullable();
            $table->foreignId('ruang_id')->constrained('ruang_ujians')->cascadeOnDelete();
            $table->foreignId('guru_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pengawas_ujians');
    }
};
