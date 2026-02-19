<?php

namespace App\Services;

use App\Dto\UserDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Pest\Support\Str;

class UserService
{

    public function getAll()
    {
        return User::select('id', 'name', 'username', 'role', 'kode_guru', 'qr_activation', 'device_id')->get();
    }

    public function getAllGuru()
    {
        return User::select('id', 'name', 'kode_guru', 'qr_activation', 'device_id')->is_guru()->active()->orderby('kode_guru', 'asc')->get();
    }

    public function create(UserDto $data)
    {
        $payload = $data->toArray();
        $payload['password'] = Hash::make($data->password);
        return User::create($payload); 
    }

    public function getById(int $id)
    {
        return User::select('id', 'name', 'username', 'role', 'kode_guru', 'qr_activation', 'device_id')->findOrFail($id);
    }

    public function update(int $id, UserDto $data)
    {
        $item = User::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete(int $id)
    {
        $item = User::findOrFail($id);
        $item->update(['deleted_at' => '1']);
        return $item;
    }

    public function generateToken()
    {
        do {
            $token = 'GURU-' . strtoupper(Str::random(20));
        } while (User::where('qr_activation', $token)->exists());

        return response()->json(['token' => $token]);
    }
}
