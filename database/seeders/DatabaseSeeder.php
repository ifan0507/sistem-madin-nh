<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // SEEDER KELAS
        // $data = [];

        // for ($i = 1; $i <= 6; $i++) {
        //     $data[] = [
        //         'nama_kelas' => $i
        //     ];
        // }

        // DB::table('kelas')->insert($data);

        // SEEDER SANTRi
        $faker = Faker::create('id_ID'); // Pakai locale Indonesia biar namanya relevan
        $santris = [];

        // Simulasi: 7 Kelas, masing-masing 15-20 santri (biar variatif)
        for ($kelasId = 1; $kelasId <= 7; $kelasId++) {

            // Generate 20 santri per kelas (Total 140 data)
            for ($i = 1; $i <= 20; $i++) {

                $gender = $faker->randomElement(['L', 'P']);

                // Tips: Generate nama berdasarkan gender biar realistis
                $nama = $gender == 'L'
                    ? $faker->firstNameMale . ' ' . $faker->lastName
                    : $faker->firstNameFemale . ' ' . $faker->lastName;

                $santris[] = [
                    'nama'           => $nama,
                    'nis'            => 'NIS' . $faker->unique()->numberBetween(100000, 999999), // Pasti unik
                    'nik'            => $faker->unique()->nik(), // Atau pake numerify kalau faker nik error
                    'tempat_lahir'   => $faker->city,
                    'tanggal_lahir'  => $faker->dateTimeBetween('-15 years', '-7 years'),
                    'jenis_kelamin'  => $gender,
                    'alamat'         => $faker->address,
                    'ayah'           => $faker->name('male'),
                    'ibu'            => $faker->name('female'),
                    'no_telp'        => $faker->phoneNumber,
                    'thn_angkatan'   => (string) $faker->numberBetween(2019, 2024),
                    'kelas_id'       => $kelasId,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }
        }

        // Insert Batch (Cepat)
        // Kita pecah jadi chunk kecil jika data terlalu banyak, tapi 140 masih aman sekali insert
        DB::table('santris')->insert($santris);
    }
}
