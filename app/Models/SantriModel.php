<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SantriModel extends Model
{
    use HasFactory;
    protected $table = 'santris';
    protected $fillable = [
        'nama',
        'nis',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'ayah',
        'ibu',
        'no_telp',
        'jenis_kelamin',
        'thn_angkatan',
        'kelas_id',
        'deleted_at',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id');
    }

    public function absensi_santri(): HasMany
    {
        return $this->hasMany(AbsensiSantriModel::class, 'santri_id');
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(PelanggaranModel::class, 'santri_id');
    }
     #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('deleted_at', '0');
    }
}
