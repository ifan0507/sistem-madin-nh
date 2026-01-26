<?php

namespace App\Services;

use App\Dto\UserDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function getAll()
    {
        return User::select('id', 'name', 'username', 'role', 'kode_guru', 'qr_activation', 'device_id')->get();
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
        // return Model::destroy($id);
    }
}
