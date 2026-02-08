<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiGuruModel extends Model
{
    use HasFactory;
    protected $table = 'absensi_gurus';
    protected $fillable = [
        'mapel_kelas_id',
        'status',
        'materi_pembelajaran',
        'ket_izin',
    ];

    public function mapel_kelas(): BelongsTo
    {
        return $this->belongsTo(MapelKelasModel::class, 'mapel_kelas_id', 'id');
    }
}
