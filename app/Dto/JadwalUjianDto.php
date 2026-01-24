<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class JadwalUjianDto
{
    public function __construct(
        public readonly Carbon $tanggal_ujian,
        public readonly int $mapel_kelas_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            tanggal_ujian: Carbon::parse($request->validated('tanggal_ujian')),
            mapel_kelas_id: (int) $request->validated('mapel_kelas_id'),
        );
    }

    public function toArray(): array
    {
        return [
            'tanggal_ujian' => $this->tanggal_ujian,
            'mapel_kelas_id' => $this->mapel_kelas_id,
        ];
    }
}
