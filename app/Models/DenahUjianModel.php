<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenahUjianModel extends Model
{
    use HasFactory;
    protected $table = 'denah_ujians';
    protected $fillable = [
        'susunan_denah',
        'total_kursi',
        'nama_ruangan',
    ];
}
