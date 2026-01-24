<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRequest extends Command
{
    protected $signature = 'make:request {name}';
    protected $description = 'Membuat file Form Request dengan template standar';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path('Http/Requests');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $filename = "{$path}/{$name}.php";

        if (File::exists($filename)) {
            $this->error("Form Request {$name} sudah ada!");
            return;
        }

        $stub = "<?php

            namespace App\Http\Requests;

            use Illuminate\Foundation\Http\FormRequest;

            class {$name} extends FormRequest
            {
                public function authorize(): bool
                {
                    // Default diset true agar tidak perlu login admin manual saat development awal
                    return true;
                }

                public function rules(): array
                {
                    return [
                        // Tambahkan aturan validasi di sini
                    ];
                }

                public function messages(): array
                {
                    return [
                        // Tambahkan pesan error custom di sini (opsional)
                    ];
                }
            }
            ";

        File::put($filename, $stub);
        $this->info("Form Request {$name} berhasil dibuat di app/Http/Requests/{$name}.php");
    }
}
