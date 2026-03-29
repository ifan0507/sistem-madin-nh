<?php

namespace App\DTO;

use Illuminate\Http\Request;

class NilaiUjianDto
{
    public function __construct(
        public readonly int $kelasId,
        public readonly int $mapelId,
        public readonly string $tahunAjaran,
        public readonly string $semester,
        public readonly ?int $guruId,
        public readonly array $nilaiSantri
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            kelasId: $request->validated('kelas_id'),
            mapelId: $request->validated('mapel_id'),
            tahunAjaran: $request->validated('tahun_ajaran'),
            semester: $request->validated('semester'),
            guruId: $request->validated('guru_id'),
            nilaiSantri: $request->validated('nilai_santri')
        );
    }

    public function toArray(): array
    {
        return [
            // Konversi properti ke array
        ];
    }
}
