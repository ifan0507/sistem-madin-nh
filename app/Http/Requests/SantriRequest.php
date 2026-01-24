<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SantriRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
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
                'unique:santris,nis'
            ],
            'nik' => [
                'required',
                'string',
                'max:50',
                'unique:santris,nik'
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
                'required',
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
