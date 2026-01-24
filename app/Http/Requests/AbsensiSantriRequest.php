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
            'santri_id' => [
                'required',
                'exists:santris,id'
            ],
            'status' => [
                'required',
                'in:1,2,3'
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
