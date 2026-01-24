<?php

namespace App\DTO;

use Illuminate\Http\Request;

class AbsensiGuruDto
{
    public function __construct(
        public readonly int $mapel_kelas_id,
        public readonly string $status,
        public readonly ?string $materi_pembelajaran,
        public readonly ?string $ket_izin,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            mapel_kelas_id: $request->input('mapel_kelas_id'),
            status: $request->input('status'),
            materi_pembelajaran: $request->input('materi_pembelajaran'),
            ket_izin: $request->input('ket_izin'),
        );
    }

    public function toArray(): array
    {
        return [
            'mapel_kelas_id' => $this->mapel_kelas_id,
            'status' => $this->status,
            'materi_pembelajaran' => $this->materi_pembelajaran,
            'ket_izin' => $this->ket_izin,
        ];
    }
}
