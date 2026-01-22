<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Membuat class Service baru di folder app/services';

    public function handle()
    {
        $name = $this->argument('name');

        $path = app_path('Services');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $filePath = $path . '/' . $name . '.php';

        if (File::exists($filePath)) {
            $this->error("Service {$name} sudah ada!");
            return;
        }

        $stub = "<?php

        namespace App\\services;

        class {$name}
        {
            public function __construct()
            {
                // Constructor logic
            }

            public function handle()
            {
                // Business logic here
            }
        }";

        File::put($filePath, $stub);
        $this->info("Service {$name} berhasil dibuat di app/services/{$name}.php");
    }
}
