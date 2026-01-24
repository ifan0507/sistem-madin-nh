<?php

namespace App\DTO;

use Illuminate\Http\Request;

class BankSoalDto
{
    public function __construct(
        public readonly array $soal,
        public readonly int $mapel_kelas_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            soal: $request->validated('soal'),
            mapel_kelas_id: (int) $request->validated('mapel_kelas_id'),
        );
    }

    public function toArray(): array
    {
        return [
            'soal' => json_encode($this->soal),
            'mapel_kelas_id' => $this->mapel_kelas_id,
        ];
    }
}
