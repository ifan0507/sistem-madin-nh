<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankSoalRequest extends FormRequest
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
            'soal' => [
                'required',
                'array',
                'min:1'
            ],
            'tahun_ajaran' => [
                'required',
                'string',
                'max:20'
            ],
            'semester' => [
                'required',
                'in:Ganjil,Genap'
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
