<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SantriRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        $santriId = $this->route('id');
        return [
            'nama' => [
                'required',
                'string',
                'max:255'
            ],
            'nis' => [
                'required',
                'string',
                'max:50',
                Rule::unique('santris', 'nis')->ignore($santriId, 'id'),

            ],
            'nik' => [
                'required',
                'string',
                'max:50',
                Rule::unique('santris', 'nik')->ignore($santriId, 'id'),
            ],
            'tempat_lahir' => [
                'required',
                'string',
                'max:255'
            ],
            'tanggal_lahir' => [
                'required',
                'date'
            ],
            'jenis_kelamin' => [
                'required',
                'in:L,P'
            ],
            'alamat' => [
                'required',
                'string'
            ],
            'ayah' => [
                'required',
                'string',
                'max:255'
            ],
            'ibu' => [
                'required',
                'string',
                'max:255'
            ],
            'no_telp' => [
                'required',
                'string',
                'max:15'
            ],
            'thn_angkatan' => [
                'required',
                'string',
                'max:4'
            ],
            'kelas_id' => [
                'nullable',
                'integer',
                'exists:kelas,id'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            // Tambahkan pesan error custom di sini (opsional)
        ];
    }
}
