<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MapelRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'kode_mapel' => [
                'required',
                'string',
                'max:10',
                Rule::unique('mapels', 'kode_mapel')->ignore($id, 'id')->where(function ($q) {
                    return $q->where('delete_at', '0');
                }),
            ],
            'nama_mapel' => [
                'required',
                'string',
                'max:50',
                Rule::unique('mapels', 'nama_mapel')->ignore($id, 'id')->where(function ($q) {
                    return $q->where('delete_at', '0');
                })
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
