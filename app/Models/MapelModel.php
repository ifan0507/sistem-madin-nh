<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MapelModel extends Model
{
    use HasFactory;
    protected $table = 'mapels';
    protected $fillable = [
        'nama_mapel',
    ];

    public function mapel_kelas(): HasMany
    {
        return $this->hasMany(MapelKelasModel::class, 'mapel_id', 'id');
    }

    public function nilai_ujian(): HasMany
    {
        return $this->hasMany(NilaiUjianModel::class, 'mapel_id', 'id');
    }
}
