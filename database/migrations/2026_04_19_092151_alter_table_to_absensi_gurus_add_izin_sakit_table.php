<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('absensi_gurus', function (Blueprint $table) {
            DB::statement('ALTER TABLE absensi_gurus DROP CONSTRAINT IF EXISTS absensi_gurus_status_check');
            DB::statement("ALTER TABLE absensi_gurus ADD CONSTRAINT absensi_gurus_status_check CHECK (status::text IN ('1', '2', '3', '4'))");
            DB::statement("COMMENT ON COLUMN absensi_gurus.status IS '1=Hadir, 2=Izin, 3=Alpha, 4=Sakit'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi_gurus', function (Blueprint $table) {
            DB::statement("ALTER TABLE absensi_gurus ADD CONSTRAINT absensi_gurus_status_check CHECK (status::text IN ('1', '2', '3'))");
            DB::statement("COMMENT ON COLUMN absensi_gurus.status IS '1=Hadir, 2=Izin, 3=Alpha'");
            DB::statement("ALTER TABLE absensi_gurus MODIFY COLUMN status ENUM('1', '2', '3') COMMENT '1=Hadir, 2=Izin, 3=Alpha'");
        });
    }
};
