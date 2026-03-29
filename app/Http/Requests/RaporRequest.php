<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RaporRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'santri_id'        => ['required', 'exists:santris,id'],
            'kelas_id'         => ['required', 'exists:kelas,id'],
            'tahun_ajaran'     => ['required', 'string', 'max:20'],
            'semester'         => ['required', 'in:Ganjil,Genap'],

            'absen_sakit'      => ['nullable', 'integer', 'min:0'],
            'absen_izin'       => ['nullable', 'integer', 'min:0'],
            'absen_alfa'       => ['nullable', 'integer', 'min:0'],

            'nilai_kerapian'   => ['nullable', 'string', 'max:2'],
            'nilai_kerajinan'  => ['nullable', 'string', 'max:2'],
            'nilai_ketertiban' => ['nullable', 'string', 'max:2'],

            'catatan'          => ['nullable', 'string'],
            'is_naik_kelas'    => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            // Tambahkan pesan error custom di sini (opsional)
        ];
    }
}
