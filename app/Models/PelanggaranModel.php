<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PelanggaranModel extends Model
{
    use HasFactory;
    protected $table = 'pelanggarans';
    protected $fillable = [
        'santri_id',
        'nama_pelanggaran',
        'pengurus_id'
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(SantriModel::class, 'santri_id');
    }

    public function pengurus(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengurus_id');
    }
}
