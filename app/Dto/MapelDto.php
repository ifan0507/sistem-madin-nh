<?php

namespace App\DTO;

use Illuminate\Http\Request;

class MapelDto
{
    public function __construct(
        private readonly string $kode_mapel,
        private readonly string $nama_mapel,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            kode_mapel: $request->input('kode_mapel'),
            nama_mapel: $request->input('nama_mapel'),
        );
    }

    public function toArray(): array
    {
        return [
            'kode_mapel' => $this->kode_mapel,
            'nama_mapel' => $this->nama_mapel,
        ];
    }
}
