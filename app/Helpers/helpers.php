<?php

if (!function_exists('getKelasArab')) {
    /**
     *
     * @param int|string $kelasId
     * @return string
     */
    function getKelasArab($kelasId)
    {
        $arabMap = [
            1 => 'صفر',
            2 => 'الأول',
            3 => 'الثاني',
            4 => 'الثالث',
            5 => 'الرابع',
            6 => 'الخامس',
            7 => 'السادس',
        ];

        return $arabMap[$kelasId] ?? $kelasId;
    }
}

if (!function_exists('getKelasIconArab')) {

    function getKelasIconArab($namaKelas)
    {
        $cleanName = strtolower(trim($namaKelas));

        return match ($cleanName) {
            'sifir', '1' => '٠',
            '2' => '١',
            '3' => '٢',
            '4' => '٣',
            '5' => '٤',
            '6' => '٥',
            '7' => '٦',
            default => '؟',
        };
    }
}

if (!function_exists('angkaKeHuruf')) {
    function angkaKeHuruf($angka)
    {
        $angka = (int)$angka;

        if ($angka == 0) return 'Nol Nol';

        $huruf = [
            0 => 'Nol',
            1 => 'Satu',
            2 => 'Dua',
            3 => 'Tiga',
            4 => 'Empat',
            5 => 'Lima',
            6 => 'Enam',
            7 => 'Tujuh',
            8 => 'Delapan',
            9 => 'Sembilan'
        ];

        if ($angka < 10) {
            return $huruf[$angka];
        }

        if ($angka == 100) {
            return 'Seratus';
        }

        $puluhan = floor($angka / 10);
        $satuan = $angka % 10;

        return $huruf[$puluhan] . ' ' . $huruf[$satuan];
    }
}
