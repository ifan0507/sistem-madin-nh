<?php

namespace App\DTO;

use Illuminate\Http\Request;

class MapelKelasDto
{
    public function __construct(
        private readonly string $kelas_id,
        private readonly string $mapel_id,
        private readonly string $guru_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('kelas_id'),
            $request->input('mapel_id'),
            $request->input('guru_id'),
        );
    }

    public function toArray(): array
    {
        return [
            'kelas_id' => $this->kelas_id,
            'mapel_id' => $this->mapel_id,
            'guru_id' => $this->guru_id,
        ];
    }
}
