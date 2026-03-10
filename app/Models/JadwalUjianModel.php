<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalUjianModel extends Model
{
    use HasFactory;
    protected $table = 'jadwal_ujians';
    protected $fillable = [
        'hari_ke',
        'tanggal_ujian',
        'kelas_id',
        'mapel_kelas_id',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id');
    }

    public function mapel_kelas(): BelongsTo
    {
        return $this->belongsTo(MapelKelasModel::class, 'mapel_kelas_id');
    }
}
