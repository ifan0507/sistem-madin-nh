<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalKBMModel extends Model
{
    use HasFactory;
    protected $table = 'jadwal_kbms';
    protected $fillable = [
        'hari',
        'mapel_kelas_id',
    ];

    public function mapel_kelas(): BelongsTo
    {
        return $this->belongsTo(MapelKelasModel::class, 'mapel_kelas_id');
    }
}
