<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalKBMRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'mapel_kelas_id' => [
                'required',
                'exists:mapel_kelas,id'
            ],
            'hari' => [
                'required',
                'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'
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
