<?php

namespace App\DTO;

use Illuminate\Http\Request;

class DenahUjianDto
{
    public function __construct(
        public readonly array $susunan_denah,
        public readonly int $total_kursi,
        public readonly string $nama_ruangan,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            susunan_denah: $request->validated('susunan_denah'),
            total_kursi: (int) $request->validated('total_kursi'),
            nama_ruangan: $request->validated('nama_ruangan'),
        );
    }

    public function toArray(): array
    {
        return [
            'susunan_denah' => json_encode($this->susunan_denah),
            'total_kursi' => $this->total_kursi,
            'nama_ruangan' => $this->nama_ruangan,
        ];
    }
}
