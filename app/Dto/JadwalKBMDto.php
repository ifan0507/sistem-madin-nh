<?php

namespace App\DTO;

use Illuminate\Http\Request;

class JadwalKBMDto
{
    public function __construct(
        private readonly ?int $id,
        private readonly int $mapel_kelas_id,
        private readonly string $hari,

    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('jadwal_id'),
            mapel_kelas_id: $request->input('mapel_kelas_id'),
            hari: $request->input('hari'),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'mapel_kelas_id' => $this->mapel_kelas_id,
            'hari' => $this->hari,
        ];
    }
}
