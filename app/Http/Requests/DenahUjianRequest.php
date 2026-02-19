<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DenahUjianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'total_kursi' => [
                'required',
                'string',
                'max:3'
            ],
            'nama_ruangan' => [
                'required',
                'string',
                'max:3'
            ],
            'kelas_ids' => [
                'required',
                'array',
                'min:1'
            ],
            'kelas_ids.*' => [
                'required',
                'integer',
                'exists:kelas,id'
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
