<?php

        namespace App\Services;

        use App\Dto\KelasDto;

        class KelasService
        {
            /**
             * Mengambil semua data
             */
            public function getAll()
            {
                // return Model::all();
            }

            /**
             * Menyimpan data baru berdasarkan DTO
             */
            public function create(KelasDto $data)
            {
                $payload = $data->toArray();
                // return Model::create($payload);
            }

            /**
             * Memperbarui data berdasarkan ID dan DTO
             */
            public function update(int $id, KelasDto $data)
            {
                // $item = Model::findOrFail($id);
                $payload = $data->toArray();
                // return $item->update($payload);
            }

            /**
             * Menghapus data
             */
            public function delete(int $id)
            {
                // return Model::destroy($id);
            }
        }