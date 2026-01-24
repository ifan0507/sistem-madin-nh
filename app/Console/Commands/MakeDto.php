<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDto extends Command
{
    protected $signature = 'make:dto {name : Nama class DTO}';

    protected $description = 'Membuat file Data Transfer Object (DTO) baru';

    public function handle()
    {
        $name = $this->argument('name');

        $path = app_path('DTO');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $filePath = $path . '/' . $name . '.php';

        if (File::exists($filePath)) {
            $this->error("File {$name} sudah ada!");
            return;
        }

        $stub = "<?php

        namespace App\\DTO;

        use Illuminate\\Http\\Request;

        class {$name}
        {
            public function __construct(
                // Definisikan properti di sini
            ) {}

            public static function fromRequest(Request \$request): self
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
        }";

        File::put($filePath, $stub);

        $this->info("DTO {$name} berhasil dibuat di app/dto/{$name}.php");
    }
}
