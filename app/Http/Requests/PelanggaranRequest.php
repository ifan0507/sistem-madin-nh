<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelanggaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'santri_id' => [
                'required',
                'exists:santris,id'
            ],
            'pengurus_id' => [
                'required',
                'exists:users,id'
            ],
            'nama_pelanggaran' => [
                'required',
                'string',
                'max:255'
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
