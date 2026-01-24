<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kelas' => [
                'required',
                'string',
                'max:50'
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
