<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaporModel extends Model
{
    use HasFactory;

    protected $table = 'rapors';

    protected $fillable = [
        'santri_id',
        'kelas_id',
        'tahun_ajaran',
        'semester',
        'absen_sakit',
        'absen_izin',
        'absen_alfa',
        'nilai_kerapian',
        'nilai_kerajinan',
        'nilai_ketertiban',
        'catatan',
        'is_naik_kelas',
        'peringkat_kelas',
    ];

    public function santri()
    {
        return $this->belongsTo(SantriModel::class, 'santri_id');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id');
    }
}
