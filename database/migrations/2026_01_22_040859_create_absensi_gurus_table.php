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
        Schema::create('absensi_gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapel_kelas_id')->constrained('mapel_kelas')->cascadeOnUpdate();
            $table->enum('status', ['1', '2', '3'])->comment('1=Hadir, 2=Izin, 3=Alpha');
            $table->text('materi_pembelajaran')->nullable();
            $table->string('ket_izin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_gurus');
    }
};
