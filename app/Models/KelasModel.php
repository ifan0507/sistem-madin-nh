<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelasModel extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = [
        'nama_kelas',
        'wali_kelas_id',
        'deleted_at'
    ];

    public function mapel_kelas(): HasMany
    {
        return $this->hasMany(MapelKelasModel::class, 'kelas_id')->active();
    }

    public function santri(): HasMany
    {
        return $this->hasMany(SantriModel::class, 'kelas_id');
    }

    public function jadwal_ujian(): HasMany
    {
        return $this->hasMany(JadwalUjianModel::class, 'kelas_id');
    }

    public function wali_kelas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function jadwal_kbms()
    {
        return $this->hasManyThrough(
            JadwalKBMModel::class,
            MapelKelasModel::class,
            'kelas_id',
            'mapel_kelas_id',
            'id',
            'id'
        );
    }
}
