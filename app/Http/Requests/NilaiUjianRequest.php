<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiUjianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelas_id'     => ['required', 'exists:kelas,id'],
            'mapel_id'     => ['required', 'exists:mapels,id'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'semester'     => ['required', 'in:Ganjil,Genap'],
            'guru_id'      => ['nullable', 'exists:users,id'],

            'nilai_santri'             => ['required', 'array', 'min:1'],
            'nilai_santri.*.santri_id' => ['required', 'exists:santris,id'],
            'nilai_santri.*.nilai'     => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nilai_santri.*.nilai.max' => 'Nilai maksimal adalah 100.',
            'nilai_santri.*.nilai.min' => 'Nilai minimal adalah 0.',
        ];
    }
}
