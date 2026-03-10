<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPengawasUjianModel extends Model
{
    protected $table = 'jadwal_pengawas_ujians';
    protected $fillable = [
        'hari_ke',
        'tanggal_ujian',
        'ruang_id',
        'guru_id',
    ];

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(RuangUjianModel::class, 'ruang_id', 'id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id', 'id');
    }
}
