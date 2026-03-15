<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalPengawasUjianRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'jadwal_pengawas_id' => 'required|exists:jadwal_pengawas_ujians,id',
            'guru_id'        => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            // Tambahkan pesan error custom di sini (opsional)
        ];
    }
}
