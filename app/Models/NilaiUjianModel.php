<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiUjianModel extends Model
{
    use HasFactory;
    protected $table = 'nilai_ujians';
    protected $fillable = [
        'nilai',
        'santri_id',
        'mapel_id',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(SantriModel::class, 'santri_id');
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MapelModel::class, 'mapel_id');
    }
}
