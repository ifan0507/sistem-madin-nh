<?php

namespace App\DTO;

use Illuminate\Http\Request;

class AbsensiSantriDto
{
    public function __construct(
        public readonly int $santri_id,
        public readonly string $status,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            santri_id: $request->input('santri_id'),
            status: $request->input('status'),
        );
    }

    public function toArray(): array
    {
        return [
            'santri_id' => $this->santri_id,
            'status' => $this->status,
        ];
    }
}
