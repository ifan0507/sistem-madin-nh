<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi_Guru extends Model
{
    use HasFactory;
    protected $table = 'absensi__gurus';
    protected $fillable = [
        'mapel_kelas_id',
        'status',
        'materi_pembelajaran',
        'ket_izin',
    ];

    public function mapel_kelas(): BelongsTo
    {
        return $this->belongsTo(Mapel_Kelas::class, 'mapel_kelas_id', 'id');
    }
}
