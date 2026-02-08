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
        Schema::create('mapel_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnUpdate();
            $table->foreignId('mapel_id')->constrained('mapels')->cascadeOnUpdate();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnUpdate();
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->year('tahun_ajaran');
            $table->enum('deleted_at', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel_kelas');
    }
};
