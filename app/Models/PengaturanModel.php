<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanModel extends Model
{
    protected $table = 'pengaturans';

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'tgl_awal_semester',
        'tgl_mulai_kumpul_soal',
        'tgl_akhir_kumpul_soal',
        'tgl_mulai_kumpul_nilai',
        'tgl_akhir_kumpul_nilai',
        'is_active',
    ];
}
