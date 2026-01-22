<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Santri extends Model
{
    use HasFactory;
    protected $table = 'santris';
    protected $fillable = [
        'nama',
        'nis',
        'nik',
        'tanggal_lahir',
        'alamat',
        'ayah',
        'ibu',
        'jenis_kelamin',
        'thn_angkatan',
        'kelas_id',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function absensi_santri(): HasMany
    {
        return $this->hasMany(Absensi_Santri::class, 'santri_id');
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'santri_id');
    }
}
