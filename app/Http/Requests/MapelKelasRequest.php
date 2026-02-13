<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MapelKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules(): array
    {
        return [
            'kelas_id' => [
                'required',
                'exists:kelas,id'
            ],
            'mapel_id' => [
                'required',
                'exists:mapels,id',
                Rule::unique('mapel_kelas', 'mapel_id')->where(function ($query) {
                    return $query->where('kelas_id', $this->kelas_id);
                }),
            ],
            'guru_id' => [
                'required',
                'exists:users,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'mapel_id.unique'   => 'Mata Pelajaran ini sudah ada di kelas tersebut.',
        ];
    }
}
