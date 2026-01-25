<?php

namespace App\Services;

use App\Dto\UserDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        // return Model::all();
    }


    public function create(UserDto $data)
    {
        $payload = $data->toArray();
        $payload['password'] = Hash::make($data->password);
        return User::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update(int $id, UserDto $data)
    {
        // $item = Model::findOrFail($id);
        $payload = $data->toArray();
        // return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete(int $id)
    {
        // return Model::destroy($id);
    }
}
