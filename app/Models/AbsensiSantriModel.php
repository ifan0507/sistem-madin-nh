<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiSantriModel extends Model
{
    use HasFactory;
    protected $table = 'absensi_santris';
    protected $fillable = [
        'santri_id',
        'status',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(SantriModel::class, 'santri_id');
    }
}
