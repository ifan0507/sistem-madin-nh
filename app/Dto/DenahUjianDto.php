<?php

namespace App\DTO;

use Illuminate\Http\Request;

class DenahUjianDto
{
    public function __construct(
        public readonly string $total_kursi,
        public readonly string $nama_ruangan,
        public readonly array $kelas_ids,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            total_kursi: $request->validated('total_kursi'),
            nama_ruangan: $request->validated('nama_ruangan'),
            kelas_ids: $request->input('kelas_ids', []),
        );
    }

    public function toArray(): array
    {
        return [
            'total_kursi' => $this->total_kursi,
            'nama_ruangan' => $this->nama_ruangan,
        ];
    }
}
