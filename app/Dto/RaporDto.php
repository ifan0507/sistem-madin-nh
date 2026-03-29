<?php

namespace App\DTO;

use Illuminate\Http\Request;

class RaporDto
{
    public function __construct(
        public readonly int $santriId,
        public readonly int $kelasId,
        public readonly string $tahunAjaran,
        public readonly string $semester,
        public readonly int $absenSakit,
        public readonly int $absenIzin,
        public readonly int $absenAlfa,
        public readonly ?string $nilaiKerapian,
        public readonly ?string $nilaiKerajinan,
        public readonly ?string $nilaiKetertiban,
        public readonly ?string $catatan,
        public readonly ?bool $isNaikKelas
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            santriId: $request->validated('santri_id'),
            kelasId: $request->validated('kelas_id'),
            tahunAjaran: $request->validated('tahun_ajaran'),
            semester: $request->validated('semester'),

            absenSakit: $request->validated('absen_sakit') ?? 0,
            absenIzin: $request->validated('absen_izin') ?? 0,
            absenAlfa: $request->validated('absen_alfa') ?? 0,

            nilaiKerapian: $request->validated('nilai_kerapian') ?? 'B',
            nilaiKerajinan: $request->validated('nilai_kerajinan') ?? 'B',
            nilaiKetertiban: $request->validated('nilai_ketertiban') ?? 'B',

            catatan: $request->validated('catatan'),
            isNaikKelas: $request->validated('is_naik_kelas')
        );
    }

    public function toArray(): array
    {
        return [
            // Konversi properti ke array
        ];
    }
}
