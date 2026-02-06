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

        $filePath = $path . '/' . $name . 'Service.php';

        if (File::exists($filePath)) {
            $this->error("Service {$name} sudah ada!");
            return;
        }

        $stub = "<?php

        namespace App\Services;

        use App\Dto\\" . $name . "Dto;

        class {$name}Service
        {
            /**
             * Mengambil semua data
             */
            public function getAll()
            {
                // return Model::all();
            }

            public function getById(\$id)
            {
                // return Model::findOrFail(\$id);
            }

            /**
             * Menyimpan data baru berdasarkan DTO
             */
            public function create({$name}Dto \$data)
            {
                \$payload = \$data->toArray();
                // return Model::create(\$payload);
            }

            /**
             * Memperbarui data berdasarkan ID dan DTO
             */
            public function update(\$id, {$name}Dto \$data)
            {
                // \$item = Model::findOrFail(\$id);
                \$payload = \$data->toArray();
                // return \$item->update(\$payload);
            }

            /**
             * Menghapus data
             */
            public function delete(\$id)
            {
                // return Model::destroy(\$id);
            }
        }";

        File::put($filePath, $stub);
        $this->info("Service {$name} berhasil dibuat di app/services/{$name}.php");
    }
}
