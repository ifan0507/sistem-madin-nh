<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MapelKelasModel extends Model
{
    use HasFactory;
    protected $table = 'mapel_kelas';
    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mapel_id',
        'semester',
        'tahun_ajaran',
        'deleted_at',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id');
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MapelModel::class, 'mapel_id');
    }

    public function absensi_guru(): HasMany
    {
        return $this->hasMany(AbsensiGuruModel::class, 'mapel_kelas_id');
    }

    public function bank_soal(): HasMany
    {
        return $this->hasMany(BankSoalModel::class, 'mapel_kelas_id');
    }

    public function jadwal_kbm(): HasMany
    {
        return $this->hasMany(JadwalKBMModel::class, 'mapel_kelas_id');
    }

    public function jadwal_ujian(): HasMany
    {
        return $this->hasMany(JadwalUjianModel::class, 'mapel_kelas_id');
    }
}
