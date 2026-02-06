<?php

        namespace App\DTO;

        use Illuminate\Http\Request;

        class MapelKelasDto
        {
            public function __construct(
                // Definisikan properti di sini
            ) {}

            public static function fromRequest(Request $request): self
            {
                return new self(
                    // Mapping request ke properti
                );
            }

            public function toArray(): array
            {
                return [
                    // Konversi properti ke array
                ];
            }
        }