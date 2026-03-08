<?php

namespace App\DTO;

use Illuminate\Http\Request;

class PengaturanDto
{
    public function __construct(
        public readonly string $tahun_ajaran,
        public readonly string $semester,
        public readonly ?bool $is_active,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->tahun_ajaran,
            $request->semester,
            $request->is_active
        );
    }

    public function toArray(): array
    {
        return [
            'tahun_ajaran' => $this->tahun_ajaran,
            'semester' => $this->semester,
            'is_active' => $this->is_active,
        ];
    }
}
