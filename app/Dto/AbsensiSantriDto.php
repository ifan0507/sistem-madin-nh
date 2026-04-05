<?php

namespace App\DTO;

use Illuminate\Http\Request;

class AbsensiSantriDto
{
    public function __construct(
        public readonly int $kelas_id,
        public readonly string $tanggal,
        public readonly array $absensi
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            kelas_id: $request->input('kelas_id'),
            tanggal: $request->input('tanggal'),
            absensi: $request->input('absensi', []),
        );
    }

    public function toArray(): array
    {
        return [
            'kelas_id' => $this->kelas_id,
            'tanggal'  => $this->tanggal,
            'absensi'  => $this->absensi,
        ];
    }
}
