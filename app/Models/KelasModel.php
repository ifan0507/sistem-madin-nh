<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelasModel extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = [
        'nama_kelas',
    ];

    public function mapel_kelas(): HasMany
    {
        return $this->hasMany(MapelKelasModel::class, 'kelas_id');
    }

    public function santri(): HasMany
    {
        return $this->hasMany(SantriModel::class, 'kelas_id');
    }
}
