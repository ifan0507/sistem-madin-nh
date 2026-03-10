<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RuangUjianModel extends Model
{
    protected $table = 'ruang_ujians';
    protected $fillable = ['nama_ruang'];

    public function jadwal_pengawas_ujian(): HasMany
    {
        return $this->hasMany(JadwalPengawasUjianModel::class, 'ruang_id', 'id');
    }
}
