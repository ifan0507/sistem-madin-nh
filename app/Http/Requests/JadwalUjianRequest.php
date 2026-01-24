<?php

            namespace App\Http\Requests;

            use Illuminate\Foundation\Http\FormRequest;

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
                        // Tambahkan aturan validasi di sini
                    ];
                }

                public function messages(): array
                {
                    return [
                        // Tambahkan pesan error custom di sini (opsional)
                    ];
                }
            }
            