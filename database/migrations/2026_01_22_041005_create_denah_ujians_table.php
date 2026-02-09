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
        Schema::create('denah_ujians', function (Blueprint $table) {
            $table->id();
            $table->jsonb('susunan_denah');
            $table->char('total_kursi', 3);
            $table->char('nama_ruangan', 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denah_ujians');
    }
};
