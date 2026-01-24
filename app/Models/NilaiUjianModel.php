<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiUjianModel extends Model
{
    use HasFactory;
    protected $table = 'nilai__ujians';
    protected $fillable = [
        'nilai',
        'santri_id',
        'mapel_id',
    ];

    public function santri()
    {
        return $this->belongsTo(SantriModel::class, 'santri_id');
    }

    public function mapel()
    {
        return $this->belongsTo(MapelModel::class, 'mapel_id');
    }
}
