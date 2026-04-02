<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiUjianPraktekRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Default diset true agar tidak perlu login admin manual saat development awal
        return true;
    }

    public function rules()
    {
        return [
            'tahun_ajaran'         => 'required|string',
            'semester'             => 'required|string',
            'nilai'                => 'required|array',
            'nilai.*.santri_id'    => 'required|exists:santris,id',
            'nilai.*.al_quran'     => 'nullable|numeric|min:0|max:100',
            'nilai.*.kitab'        => 'nullable|numeric|min:0|max:100',
            'nilai.*.muhafadloh'   => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function messages()
    {
        return [
            'nilai.*.al_quran.max' => 'Nilai Al-Qur\'an tidak boleh lebih dari 100.',
            'nilai.*.kitab.max' => 'Nilai Kitab tidak boleh lebih dari 100.',
            'nilai.*.muhafadloh.max' => 'Nilai Muhafadloh tidak boleh lebih dari 100.',
        ];
    }
}
