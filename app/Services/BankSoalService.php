<?php

namespace App\Services;

use App\Dto\BankSoalDto;
use App\Models\BankSoalModel;
use App\Models\KelasModel;
use App\Models\MapelKelasModel;

class BankSoalService
{
    protected array $rules;
    public function __construct()
    {
        $this->rules = config('pegon_rules');
    }

    public function getBankSoal()
    {
        $kelasList = KelasModel::orderBy('id', 'asc')->get();
        $mapelKelas = MapelKelasModel::with(['mapel', 'guru', 'bank_soal'])->active()->get();
        $totalMapel = $mapelKelas->count();
        $sudahMengumpulkan = $mapelKelas->filter(function ($item) {
            return $item->bank_soal->isNotEmpty();
        })->count();
        $belumMengumpulkan = $totalMapel - $sudahMengumpulkan;
        $mapelPerKelas = $mapelKelas->groupBy('kelas_id');
        return [
            'kelasList'     => $kelasList,
            'mapelPerKelas' => $mapelPerKelas,
            'totalMapel'        => $totalMapel,
            'sudahMengumpulkan' => $sudahMengumpulkan,
            'belumMengumpulkan' => $belumMengumpulkan
        ];
    }

    public function getById($id)
    {
        // return Model::findOrFail($id);
    }

    public function getDataCetakSoal($id)
    {
        $bankSoal = BankSoalModel::with(['mapel_kelas.mapel', 'mapel_kelas.kelas'])->findOrFail($id);

        return [
            'bank_soal'   => $bankSoal,
            'mapel_kelas' => $bankSoal->mapel_kelas
        ];
    }

    public function create(BankSoalDto $data)
    {
        $susunanSoal = [];

        foreach ($data->soal as $index => $soalLatin) {
            $soalPegon = $this->generate($soalLatin);
            $susunanSoal[] = [
                'nomor_soal' => $index + 1,
                'soal_latin' => $soalLatin,
                'soal_pegon' => $soalPegon,
            ];
        }
        return BankSoalModel::create([
            'mapel_kelas_id' => $data->mapel_kelas_id,
            'soal'           => $susunanSoal,
        ]);
    }

    public function updateSoal($id, array $soalData)
    {
        $bank_soal = BankSoalModel::findOrFail($id);

        $soal_baru = [];
        foreach ($soalData as $item) {
            $soal_baru[] = [
                'soal_latin' => $item['latin'] ?? '',
                'soal_pegon' => $item['pegon'] ?? ''
            ];
        }

        $bank_soal->soal = $soal_baru;
        $bank_soal->save();

        return $bank_soal;
    }


    public function generate(string $text): string
    {
        $words = explode(' ', strtolower($text));
        $processedWords = [];

        foreach ($words as $word) {
            $result = '';
            $i = 0;
            $length = strlen($word);

            while ($i < $length) {
                $char = $word[$i];
                $nextChar = ($i + 1 < $length) ? $word[$i + 1] : '';
                $combined = $char . $nextChar;

                if ($i === 0 && isset($this->rules['vowels_awal'][$char])) {
                    $result .= $this->rules['vowels_awal'][$char];
                    $i++;
                } elseif (isset($this->rules['mapping'][$combined])) {
                    $result .= $this->rules['mapping'][$combined];
                    $i += 2;
                } elseif (isset($this->rules['mapping'][$char])) {
                    $result .= $this->rules['mapping'][$char];
                    $i++;
                } elseif (isset($this->rules['punctuation'][$char])) {
                    $result .= $this->rules['punctuation'][$char];
                    $i++;
                } elseif (isset($this->rules['vowels'][$char])) {
                    $result .= $this->rules['vowels'][$char];
                    $i++;
                } else {
                    $result .= $char;
                    $i++;
                }
            }
            $processedWords[] = $result;
        }

        return implode(' ', $processedWords);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, BankSoalDto $data)
    {
        // $item = Model::findOrFail($id);
        $payload = $data->toArray();
        // return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        // return Model::destroy($id);
    }
}
