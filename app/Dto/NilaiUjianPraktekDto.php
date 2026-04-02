<?php

namespace App\DTO;

use App\Http\Requests\NilaiUjianPraktekRequest;
use Illuminate\Http\Request;

class NilaiUjianPraktekDto
{
    public function __construct(
        public readonly string $tahunAjaran,
        public readonly string $semester,
        public readonly array $nilaiData
    ) {}

    public static function fromRequest(NilaiUjianPraktekRequest $request): self
    {
        return new self(
            tahunAjaran: $request->validated('tahun_ajaran'),
            semester: $request->validated('semester'),
            nilaiData: $request->validated('nilai')
        );
    }

    public function toArray(): array
    {
        return [
            // Konversi properti ke array
        ];
    }
}
