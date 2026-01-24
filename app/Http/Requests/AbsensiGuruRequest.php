<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsensiGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mapel_kelas_id' => [
                'required',
                'exists:mapel_kelas,id'
            ],
            'status' => [
                'required',
                'in:1,2,3'
            ],
            'materi_pembelajaran' => [
                'required_if:status,1',
                'nullable',
                'string'
            ],
            'ket_izin' => [
                'required_if:status,2',
                'nullable',
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
