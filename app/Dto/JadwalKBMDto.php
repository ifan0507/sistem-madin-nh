<?php

namespace App\DTO;

use Illuminate\Http\Request;

class JadwalKBMDto
{
    public function __construct(
        public readonly int $mapel_kelas_id,
        public readonly string $hari,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            mapel_kelas_id: (int) $request->validated('mapel_kelas_id'),
            hari: $request->validated('hari'),
        );
    }

    public function toArray(): array
    {
        return [
            'mapel_kelas_id' => $this->mapel_kelas_id,
            'hari' => $this->hari,
        ];
    }
}
