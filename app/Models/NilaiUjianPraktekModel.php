<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiUjianPraktekModel extends Model
{
    protected $table = 'nilai_ujian_prakteks';
    protected $fillable = [
        'santri_id',
        'semester',
        'tahun_ajaran',
        'al_quran',
        'kitab',
        'muhafadloh'
    ];

    public function santri()
    {
        return $this->belongsTo(SantriModel::class);
    }
}
