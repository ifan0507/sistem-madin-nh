<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MapelKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'kelas_id' => [
                'required',
                'exists:kelas,id'
            ],
            'mapel_id' => [
                'required',
                'exists:mapels,id'
            ],
            'guru_id' => [
                'required',
                'exists:gurus,id'
            ],
            'semester' => [
                'required',
                'in:Ganjil,Genap'
            ],
            'tahun_ajaran' => [
                'required',
                'string',
                'max:9'
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
