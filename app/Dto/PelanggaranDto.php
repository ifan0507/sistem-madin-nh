<?php

namespace App\DTO;

use Illuminate\Http\Request;

class PelanggaranDto
{
    public function __construct(
        public readonly int $santri_id,
        public readonly string $nama_pelanggaran,
        public readonly int $pengurus_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            santri_id: (int) $request->validated('santri_id'),
            nama_pelanggaran: $request->validated('nama_pelanggaran'),
            pengurus_id: (int) $request->validated('pengurus_id'),
        );
    }

    public function toArray(): array
    {
        return [
            'santri_id' => $this->santri_id,
            'nama_pelanggaran' => $this->nama_pelanggaran,
            'pengurus_id' => $this->pengurus_id,
        ];
    }
}
