<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mapel_Kelas extends Model
{
    use HasFactory;
    protected $table = 'mapel__kelas';
    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mapel_id',
        'semester',
        'tahun_ajaran',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function absensi_guru(): HasMany
    {
        return $this->hasMany(Absensi_Guru::class, 'mapel_kelas_id');
    }

    public function bank_soal(): HasMany
    {
        return $this->hasMany(Bank_Soal::class, 'mapel_kelas_id');
    }

    public function jadwal_kbm(): HasMany
    {
        return $this->hasMany(Jadwal_KBM::class, 'mapel_kelas_id');
    }

    public function jadwal_ujian(): HasMany
    {
        return $this->hasMany(Jadwal_Ujian::class, 'mapel_kelas_id');
    }
}
