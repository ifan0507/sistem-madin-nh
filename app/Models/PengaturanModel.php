<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanModel extends Model
{
    protected $table = 'pengaturans';

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'is_active',
    ];
}
