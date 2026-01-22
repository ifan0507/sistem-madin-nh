<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal_KBM extends Model
{
    use HasFactory;
    protected $table = 'jadwal__kbms';
    protected $fillable = [
        'hari',
        'mapel_kelas_id',
    ];

    public function mapel_kelas(): BelongsTo
    {
        return $this->belongsTo(Mapel_Kelas::class, 'mapel_kelas_id');
    }
}
