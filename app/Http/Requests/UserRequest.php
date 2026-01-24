<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
            'role' => [
                'required',
                'in:1,2,3',
            ],
            'kode_guru' => [
                'nullable',
                'string',
                'max:50',
                'unique:users,kode_guru'
            ],
            'qr_activation' => [
                'nullable',
                'string',
                'max:255',
                'unique:users,qr_activation'
            ],
            'device_id' => [
                'nullable',
                'string',
                'max:255',
                'unique:users,device_id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // Tambahkan pesan error custom di sini (opsional)
        ];
    }
}
