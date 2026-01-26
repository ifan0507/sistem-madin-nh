<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

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
                Rule::unique('users', 'username')->ignore($userId),
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
                Rule::unique('users', 'kode_guru')->ignore($userId),
            ],
            'qr_activation' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'qr_activation')->ignore($userId)
            ],
            'device_id' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'device_id')->ignore($userId),
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
