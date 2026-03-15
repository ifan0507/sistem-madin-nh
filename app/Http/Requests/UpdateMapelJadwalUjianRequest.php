<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMapelJadwalUjianRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'jadwal_id'      => 'required|exists:jadwal_ujians,id',
            'mapel_kelas_id' => 'nullable|exists:mapel_kelas,id',
        ];
    }

    public function messages(): array
    {
        return [
            // Tambahkan pesan error custom di sini (opsional)
        ];
    }
}
