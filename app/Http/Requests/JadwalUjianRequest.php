<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JadwalUjianRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'hari_ke' => 'required|integer|min:1|max:6',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('jadwal_ujians', 'tanggal_ujian')->whereNot('hari_ke', $this->hari_ke)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.unique' => 'Tanggal ujian sudah digunakan untuk hari lain.',
        ];
    }
}
