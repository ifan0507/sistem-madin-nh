<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'kode_guru',
        'qr_activation',
        'device_id',
        'delete_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function mapel_kelas(): HasMany
    {
        return $this->hasMany(MapelKelasModel::class, 'guru_id');
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(PelanggaranModel::class, 'user_id');
    }

    #[Scope]
    public function is_guru(Builder $query)
    {
        return $query->where('role', '2');
    }

    #[Scope]
    public function is_pengurus(Builder $query)
    {
        return $query->where('role', '3');
    }

    #[Scope]
    public function active(Builder $query)
    {
        return $query->where('delete_at', '0');
    }
}
