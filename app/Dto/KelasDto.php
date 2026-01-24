<?php

namespace App\DTO;

use Illuminate\Http\Request;

class KelasDto
{
    public function __construct(
        public readonly string $nama_kelas,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            nama_kelas: $request->input('nama_kelas'),
        );
    }

    public function toArray(): array
    {
        return [
            'nama_kelas' => $this->nama_kelas,
        ];
    }
}
