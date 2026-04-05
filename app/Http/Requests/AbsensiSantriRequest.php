<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsensiSantriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelas_id' => [
                'required',
                'exists:kelas,id'
            ],
            'tanggal' => [
                'required',
                'date'
            ],
            'absensi' => [
                'required',
                'array',
                'min:1'
            ],
            'absensi.*.santri_id' => [
                'required',
                'exists:santris,id'
            ],
            'absensi.*.status' => [
                'required',
                'in:1,2,3,4'
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
