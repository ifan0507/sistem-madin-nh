<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelanggaranModel extends Model
{
    use HasFactory;
    protected $table = 'pelanggarans';
    protected $fillable = [
        'santri_id',
        'nama_pelanggaran',
        'pengurus_id'
    ];
}
