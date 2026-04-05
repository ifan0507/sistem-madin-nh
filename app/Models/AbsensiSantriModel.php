<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiSantriModel extends Model
{
    use HasFactory;
    protected $table = 'absensi_santris';
    protected $fillable = [
        'santri_id',
        'tanggal',
        'kelas_id',
        'status',
        'tahun_ajaran',
        'semester',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(SantriModel::class, 'santri_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id');
    }
}
